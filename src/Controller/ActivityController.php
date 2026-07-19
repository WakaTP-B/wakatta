<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
use App\Repository\ActivityLogRepository;
use App\Repository\VocabularyRepository;
use App\Repository\XpTransactionRepository;
use App\Service\QcmAnswerChecker;
use App\Service\QcmGenerator;
use App\Service\QcmSessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ActivityController extends AbstractController
{
    #[Route('/vocabulaire', name: 'app_activity_vocabulaire')]
    #[IsGranted('ROLE_USER')]
    public function vocabulaire(
        Request $request,
        QcmGenerator $qcmGenerator,
        QcmSessionManager $qcmSessionManager,
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

        // Continue la session si id transmis via l'URL
        // (via le lien "Suivant") - sinon nouvelle session
        $session = $sessionIdParam !== null
            ? $qcmSessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser())
            : null;

        if ($session === null) {
            $session = $qcmSessionManager->createSession($this->getUser());
        }

        // Si le mot ET les choix sont déjà fixés dans l'URL (rechargement de page),
        // on reconstruit la même question à l'identique - rien ne doit changer au F5
        if ($wordIdParam !== null && $choicesParam !== null) {
            $vocabulary = $vocabularyRepository->find((int) $wordIdParam);
            $choices = explode(',', $choicesParam);
            $question = $vocabulary ? $qcmGenerator->buildQuestionFromFixedChoices($vocabulary, $difficulty, $choices) : null;
        } else {
            // On récupère les mots déjà posés dans cette session, pour ne pas les reposer
            $excludedIds = $activityLogRepository->findVocabularyIdsForSession($session);
            $question = $qcmGenerator->generateQuestion($difficulty, $excludedIds);

            if ($question) {
                // On fixe le mot ET les choix dans l'URL, pour que les futurs relodads réaffichent exactement la même question (mot + distracteurs).
                return $this->redirectToRoute('app_activity_vocabulaire', [
                    'level' => $difficulty->value,
                    'session' => $session->getId(),
                    'word' => $question->vocabulary->getId(),
                    'choices' => implode(',', $question->choices),
                ]);
            }
        }

        if (!$question) {
            $this->addFlash('error', 'Aucun mot disponible pour ce niveau.');

            return $this->redirectToRoute('app_dashboard');
        }

        $questionNumber = $qcmSessionManager->getCurrentQuestionNumber($session);

        return $this->render('activity/qcm/index.html.twig', [
            'question' => $question,
            'questionNumber' => $questionNumber,
            'session' => $session,
        ]);
    }

    #[Route('/vocabulaire/reponse', name: 'app_activity_vocabulaire_reponse', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function vocabulaireReponse(
        Request $request,
        VocabularyRepository $vocabularyRepository,
        QcmAnswerChecker $qcmAnswerChecker,
        QcmSessionManager $qcmSessionManager,
    ): Response {
        // Récupération des données envoyées par le formulaire (champs cachés)
        $vocabularyId = $request->request->get('vocabularyId');
        $levelParam = $request->request->get('difficulty');
        $submittedAnswer = $request->request->get('answer');
        $sessionId = $request->request->get('sessionId');

        $vocabulary = $vocabularyRepository->find($vocabularyId);
        $difficulty = DifficultyLevel::from($levelParam);

        $session = $qcmSessionManager->findOngoingSession((int) $sessionId, $this->getUser());

        $result = $qcmAnswerChecker->checkAnswer(
            user: $this->getUser(),
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            submittedAnswer: $submittedAnswer,
            session: $session,
        );

        // On check si la session est terminée (le récap s'affichera au clic sur "Suivant")
        $qcmSessionManager->closeSessionIfComplete($session);

        return $this->render('activity/qcm/_result_modal.html.twig', [
            'isCorrect' => $result['isCorrect'],
            'xpAmount' => $result['xpAmount'],
            'correctAnswer' => $result['correctAnswer'],
            'difficulty' => $difficulty,
            'session' => $session,
        ]);
    }

    #[Route('/vocabulaire/recap', name: 'app_activity_vocabulaire_recap')]
    #[IsGranted('ROLE_USER')]
    public function vocabulaireRecap(
        Request $request,
        QcmSessionManager $qcmSessionManager,
        ActivityLogRepository $activityLogRepository,
        XpTransactionRepository $xpTransactionRepository,
    ): Response {
        $sessionId = (int) $request->query->get('session');
        $difficulty = DifficultyLevel::from($request->query->get('difficulty'));

        $session = $qcmSessionManager->getSessionForUser($sessionId, $this->getUser());

        if ($session === null) {
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('activity/qcm/recap.html.twig', [
            'successCount' => $activityLogRepository->countSuccessForSession($session),
            'totalXp' => $xpTransactionRepository->getTotalXpForSession($session),
            'difficulty' => $difficulty,
        ]);
    }

    #[Route('/hiragana/calligraphie', name: 'app_activity_calligraphie')]
    #[IsGranted('ROLE_USER')]
    public function calligraphie(): Response
    {
        return $this->render('activity/calligraphie.html.twig');
    }

    #[Route('/hiragana/completion', name: 'app_activity_completion')]
    #[IsGranted('ROLE_USER')]
    public function completion(): Response
    {
        return $this->render('activity/completion.html.twig');
    }

    #[Route('/hiragana/assemblage', name: 'app_activity_assemblage')]
    #[IsGranted('ROLE_USER')]
    public function assemblage(): Response
    {
        return $this->render('activity/assemblage.html.twig');
    }
}
