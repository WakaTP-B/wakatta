<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
use App\Repository\ActivityLogRepository;
use App\Repository\XpTransactionRepository;
use App\Service\AssemblageAnswerChecker;
use App\Service\AssemblageGenerator;
use App\Service\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AssemblageController extends AbstractController
{
    private const TIMER_SESSION_ASSEMBLAGE = 45;

    #[Route('/hiragana/assemblage', name: 'app_activity_assemblage')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        AssemblageGenerator $assemblageGenerator,
        SessionManager $sessionManager,
        XpTransactionRepository $xpTransactionRepository,
    ): Response {
        $levelParam = $request->query->get('level');

        try {
            $difficulty = DifficultyLevel::from($levelParam);
        } catch (\ValueError) {
            $this->addFlash('error', 'Merci de choisir un niveau avant de commencer.');

            return $this->redirectToRoute('app_dashboard');
        }

        $httpSession = $request->getSession();

        $sessionIdParam = $httpSession->get('assemblage_active_session_id');
        $storedGrid = $sessionIdParam !== null ? $httpSession->get('assemblage_grid_' . $sessionIdParam) : null;

        if ($sessionIdParam !== null && $storedGrid !== null) {
            $session = $sessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser());

            if ($session === null) {
                return $this->redirectToRoute('app_dashboard');
            }

            // Check cote serveur si session expiré
            $elapsedSeconds = time() - $session->getStartedAt()->getTimestamp();
            if ($elapsedSeconds >= self::TIMER_SESSION_ASSEMBLAGE) {
                $sessionManager->closeSessionAndSaveTotalXp($session, $xpTransactionRepository);

                $httpSession->remove('assemblage_active_session_id');
                $httpSession->remove('assemblage_grid_' . $session->getId());

                return $this->redirectToRoute('app_activity_assemblage_recap', [
                    'session' => $session->getId(),
                    'difficulty' => $difficulty->value,
                ]);
            }

            $grid = $assemblageGenerator->buildGridFromFixedTiles($difficulty, $storedGrid);

            // Temps restant reel, evite de reset le timer au F5
            $remainingSeconds = self::TIMER_SESSION_ASSEMBLAGE - $elapsedSeconds;

            return $this->render('activity/assemblage/index.html.twig', [
                'grid' => $grid,
                'session' => $session,
                'difficulty' => $difficulty,
                'remainingSeconds' => $remainingSeconds,
                'timerDuration' => self::TIMER_SESSION_ASSEMBLAGE,
            ]);
        }

        // Nouvelle session + nouvelle grille, fixees en session HTTP
        $grid = $assemblageGenerator->generateGrid($difficulty);

        if ($grid === null) {
            $this->addFlash('error', 'Pas assez de vocabulaire disponible pour ce niveau.');

            return $this->redirectToRoute('app_dashboard');
        }

        $session = $sessionManager->createSession($this->getUser());
        $tileIds = array_map(fn($hiragana) => $hiragana->getId(), $grid->tiles);

        $httpSession->set('assemblage_active_session_id', $session->getId());
        $httpSession->set('assemblage_grid_' . $session->getId(), $tileIds);

        return $this->redirectToRoute('app_activity_assemblage', [
            'level' => $difficulty->value,
        ]);
    }

    #[Route('/hiragana/assemblage/valider', name: 'app_activity_assemblage_valider', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function valider(
        Request $request,
        AssemblageAnswerChecker $assemblageAnswerChecker,
        SessionManager $sessionManager,
    ): Response {
        $selectedIdsParam = $request->request->get('selected');
        $levelParam = $request->request->get('difficulty');
        $sessionIdParam = $request->request->get('sessionId');

        $difficulty = DifficultyLevel::from($levelParam);
        $session = $sessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser());

        if ($session === null) {
            throw $this->createNotFoundException();
        }

        $selectedIds = array_map('intval', explode(',', $selectedIdsParam));

        $result = $assemblageAnswerChecker->checkAnswer(
            user: $this->getUser(),
            selectedHiraganaIds: $selectedIds,
            difficulty: $difficulty,
            session: $session,
        );

        return $this->json([
            'result' => $result['result'],
            'xpAmount' => $result['xpAmount'],
            'hiragana' => $result['vocabulary']?->getHiragana(),
            'translation' => $result['vocabulary']?->getFrench(),
        ]);
    }

    #[Route('/hiragana/assemblage/terminer', name: 'app_activity_assemblage_terminer', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function terminer(
        Request $request,
        SessionManager $sessionManager,
        XpTransactionRepository $xpTransactionRepository,
    ): Response {
        $sessionIdParam = $request->request->get('sessionId');
        $levelParam = $request->request->get('difficulty');

        $session = $sessionManager->getSessionForUser((int) $sessionIdParam, $this->getUser());

        if ($session === null) {
            throw $this->createNotFoundException();
        }

        // Cloture session (timer expiré), calcul Xp total, redirect to recap
        $sessionManager->closeSessionAndSaveTotalXp($session, $xpTransactionRepository);

        $request->getSession()->remove('assemblage_active_session_id');
        $request->getSession()->remove('assemblage_grid_' . $session->getId());

        return $this->redirectToRoute('app_activity_assemblage_recap', [
            'session' => $session->getId(),
            'difficulty' => $levelParam,
        ]);
    }

    #[Route('/hiragana/assemblage/recap', name: 'app_activity_assemblage_recap')]
    #[IsGranted('ROLE_USER')]
    public function recap(
        Request $request,
        SessionManager $sessionManager,
        ActivityLogRepository $activityLogRepository,
    ): Response {
        $sessionId = (int) $request->query->get('session');
        $difficulty = DifficultyLevel::from($request->query->get('difficulty'));
        $session = $sessionManager->getSessionForUser($sessionId, $this->getUser());

        if ($session === null) {
            return $this->redirectToRoute('app_dashboard');
        }

        $foundVocabularies = $activityLogRepository->findSuccessVocabulariesForSession($session);

        return $this->render('activity/assemblage/recap.html.twig', [
            'wordsFoundCount' => count($foundVocabularies),
            'foundVocabularies' => $foundVocabularies,
            'totalXp' => $session->getTotalXp(),
            'difficulty' => $difficulty,
        ]);
    }
}
