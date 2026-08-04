<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
use App\Repository\ActivityLogRepository;
use App\Repository\VocabularyRepository;
use App\Repository\XpTransactionRepository;
use App\Service\QcmAnswerChecker;
use App\Service\QcmGenerator;
use App\Service\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class QcmController extends AbstractController
{
    #[Route('/vocabulaire', name: 'app_activity_vocabulaire')]
    #[IsGranted('ROLE_USER')]
    public function vocabulaire(
        Request $request,
        QcmGenerator $qcmGenerator,
        SessionManager $qcmSessionManager,
        ActivityLogRepository $activityLogRepository,
        VocabularyRepository $vocabularyRepository,
    ): Response {
        $levelParam = $request->query->get('level');

        try {
            $difficulty = DifficultyLevel::from($levelParam);
        } catch (\ValueError) {
            $this->addFlash('error', 'Merci de choisir un niveau avant de commencer.');

            return $this->redirectToRoute('app_dashboard');
        }

        $httpSession = $request->getSession();

        // On stocke l'ID de la session en cours dans la session HTTP, pour pouvoir retrouver la session côté serveur
        $sessionIdParam = $httpSession->get('qcm_active_session_id');

        $session = $sessionIdParam !== null
            ? $qcmSessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser())
            : null;

        if ($session === null) {
            $session = $qcmSessionManager->createSession($this->getUser());
            $httpSession->set('qcm_active_session_id', $session->getId());
        }

        // Le mot et les choix figés sont eux aussi stockés côté serveur
        $sessionKey = 'qcm_question_' . $session->getId();
        $storedQuestion = $httpSession->get($sessionKey);

        if ($storedQuestion !== null) {
            $vocabulary = $vocabularyRepository->find($storedQuestion['wordId']);
            $question = $vocabulary
                ? $qcmGenerator->buildQuestionFromFixedChoices($vocabulary, $difficulty, $storedQuestion['choices'])
                : null;
        } else {
            $excludedIds = $activityLogRepository->findVocabularyIdsForSession($session);
            $question = $qcmGenerator->generateQuestion($difficulty, $excludedIds);

            if ($question) {
                $httpSession->set($sessionKey, [
                    'wordId' => $question->vocabulary->getId(),
                    'choices' => $question->choices,
                ]);

                return $this->redirectToRoute('app_activity_vocabulaire', [
                    'level' => $difficulty->value,
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
        SessionManager $sessionManager,
    ): Response {
        // Récupération des données envoyées par le formulaire (champs cachés)
        $vocabularyId = $request->request->get('vocabularyId');
        $levelParam = $request->request->get('difficulty');
        $submittedAnswer = $request->request->get('answer');
        $sessionId = $request->request->get('sessionId');

        $vocabulary = $vocabularyRepository->find($vocabularyId);
        $difficulty = DifficultyLevel::from($levelParam);

        $session = $sessionManager->findOngoingSession((int) $sessionId, $this->getUser());

        $result = $qcmAnswerChecker->checkAnswer(
            user: $this->getUser(),
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            submittedAnswer: $submittedAnswer,
            session: $session,
        );

        // La question est répondue : on retire son état figé de la session HTTP,
        // pour que le prochain GET /vocabulaire en génère une nouvelle plutôt que de rejouer celle-ci.
        $request->getSession()->remove('qcm_question_' . $session->getId());

        // On check si la session est terminée (le récap s'affichera au clic sur "Suivant")
        $sessionManager->closeSessionIfComplete($session);

        return $this->render('activity/qcm/_result_modal.html.twig', [
            'isCorrect' => $result['isCorrect'],
            'xpAmount' => $result['xpAmount'],
            'correctAnswer' => $result['correctAnswer'],
            'correctRomaji' => $result['correctRomaji'],
            'difficulty' => $difficulty,
            'session' => $session,
        ]);
    }

    #[Route('/vocabulaire/recap', name: 'app_activity_vocabulaire_recap')]
    #[IsGranted('ROLE_USER')]
    public function vocabulaireRecap(
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

        return $this->render('activity/qcm/recap.html.twig', [
            'successCount' => $activityLogRepository->countSuccessForSession($session),
            'totalXp' => $xpTransactionRepository->getTotalXpForSession($session),
            'difficulty' => $difficulty,
        ]);
    }
}
