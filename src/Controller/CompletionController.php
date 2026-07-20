<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
use App\Repository\ActivityLogRepository;
use App\Repository\VocabularyRepository;
use App\Repository\XpTransactionRepository;
use App\Service\CompletionAnswerChecker;
use App\Service\CompletionGenerator;
use App\Service\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CompletionController extends AbstractController
{
    #[Route('/hiragana/completion', name: 'app_activity_completion')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        CompletionGenerator $completionGenerator,
        SessionManager $sessionManager,
        ActivityLogRepository $activityLogRepository,
        VocabularyRepository $vocabularyRepository,
    ): Response {
        $levelParam = $request->query->get('level');
        $sessionIdParam = $request->query->get('session');
        $wordIdParam = $request->query->get('word');
        $choicesParam = $request->query->get('choices');

        try {
            $difficulty = DifficultyLevel::from($levelParam);
        } catch (\ValueError) {
            $this->addFlash('error', 'Merci de choisir un niveau avant de commencer.');

            return $this->redirectToRoute('app_dashboard');
        }

        $session = $sessionIdParam !== null
            ? $sessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser())
            : null;

        if ($session === null) {
            $session = $sessionManager->createSession($this->getUser());
        }

        if ($wordIdParam !== null && $choicesParam !== null) {
            $vocabulary = $vocabularyRepository->find((int) $wordIdParam);
            $choiceIds = array_map('intval', explode(',', $choicesParam));
            $question = $vocabulary ? $completionGenerator->buildQuestionFromFixedChoices($vocabulary, $difficulty, $choiceIds) : null;
        } else {
            $excludedIds = $activityLogRepository->findVocabularyIdsForSession($session);
            $question = $completionGenerator->generateQuestion($difficulty, $excludedIds);

            if ($question) {
                $choiceIds = array_map(fn($h) => $h->getId(), $question->choices);

                return $this->redirectToRoute('app_activity_completion', [
                    'level' => $difficulty->value,
                    'session' => $session->getId(),
                    'word' => $question->vocabulary->getId(),
                    'choices' => implode(',', $choiceIds),
                ]);
            }
        }

        if (!$question) {
            $this->addFlash('error', 'Aucun mot disponible pour ce niveau.');

            return $this->redirectToRoute('app_dashboard');
        }

        $questionNumber = $sessionManager->getCurrentQuestionNumber($session);

        return $this->render('activity/completion/index.html.twig', [
            'question' => $question,
            'questionNumber' => $questionNumber,
            'session' => $session,
        ]);
    }

    #[Route('/hiragana/completion/reponse', name: 'app_activity_completion_reponse', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function reponse(
        Request $request,
        VocabularyRepository $vocabularyRepository,
        CompletionAnswerChecker $completionAnswerChecker,
        SessionManager $sessionManager,
    ): Response {
        $vocabularyId = $request->request->get('vocabularyId');
        $levelParam = $request->request->get('difficulty');
        $submittedAnswer = $request->request->get('answer');
        $sessionId = $request->request->get('sessionId');

        $vocabulary = $vocabularyRepository->find($vocabularyId);
        $difficulty = DifficultyLevel::from($levelParam);
        $submittedHiraganaIds = $submittedAnswer ? array_map('intval', explode(',', $submittedAnswer)) : [];

        $session = $sessionManager->findOngoingSession((int) $sessionId, $this->getUser());

        $result = $completionAnswerChecker->checkAnswer(
            user: $this->getUser(),
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            submittedHiraganaIds: $submittedHiraganaIds,
            session: $session,
        );

        $sessionManager->closeSessionIfComplete($session);

        return $this->render('activity/completion/_result_modal.html.twig', [
            'isCorrect' => $result['isCorrect'],
            'xpAmount' => $result['xpAmount'],
            'correctWord' => $result['correctWord'],
            'difficulty' => $difficulty,
            'session' => $session,
        ]);
    }

    #[Route('/hiragana/completion/recap', name: 'app_activity_completion_recap')]
    #[IsGranted('ROLE_USER')]
    public function recap(
        Request $request,
        SessionManager $sessionManager,
        ActivityLogRepository $activityLogRepository,
        XpTransactionRepository $xpTransactionRepository,
    ): Response {
        $sessionId = (int) $request->query->get('session');
        $difficulty = DifficultyLevel::from($request->query->get('difficulty'));

        $session = $sessionManager->getSessionForUser($sessionId, $this->getUser());

        if ($session === null) {
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('activity/completion/recap.html.twig', [
            'successCount' => $activityLogRepository->countSuccessForSession($session),
            'totalXp' => $xpTransactionRepository->getTotalXpForSession($session),
            'difficulty' => $difficulty,
        ]);
    }
}
