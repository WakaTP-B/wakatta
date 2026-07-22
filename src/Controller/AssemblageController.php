<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
use App\Repository\XpTransactionRepository;
use App\Service\AssemblageAnswerChecker;
use App\Service\AssemblageGenerator;
use App\Service\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

final class AssemblageController extends AbstractController
{
    #[Route('/hiragana/assemblage', name: 'app_activity_assemblage')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        AssemblageGenerator $assemblageGenerator,
        SessionManager $sessionManager,
    ): Response {
        $levelParam = $request->query->get('level');
        $sessionIdParam = $request->query->get('session');
        $tilesParam = $request->query->get('tiles');

        // Pas de niveau choisi -> modal de selection
        if ($levelParam === null) {
            return $this->render('activity/assemblage/index.html.twig', [
                'showLevelModal' => true,
            ]);
        }

        try {
            $difficulty = DifficultyLevel::from($levelParam);
        } catch (\ValueError) {
            $this->addFlash('error', 'Merci de choisir un niveau avant de commencer.');

            return $this->redirectToRoute('app_activity_assemblage');
        }

        // Grille + session deja fixees dans l'URL (F5) -> on reconstruit a l'identique
        if ($sessionIdParam !== null && $tilesParam !== null) {
            $session = $sessionManager->findOngoingSession((int) $sessionIdParam, $this->getUser());

            if ($session === null) {
                return $this->redirectToRoute('app_activity_assemblage');
            }

            $tileIds = array_map('intval', explode(',', $tilesParam));
            $grid = $assemblageGenerator->buildGridFromFixedTiles($difficulty, $tileIds);

            return $this->render('activity/assemblage/index.html.twig', [
                'showLevelModal' => false,
                'grid' => $grid,
                'session' => $session,
                'difficulty' => $difficulty,
            ]);
        }

        // Premiere generation : nouvelle session + nouvelle grille, on fixe tout dans l'URL
        $grid = $assemblageGenerator->generateGrid($difficulty);

        if ($grid === null) {
            $this->addFlash('error', 'Pas assez de vocabulaire disponible pour ce niveau.');

            return $this->redirectToRoute('app_dashboard');
        }

        $session = $sessionManager->createSession($this->getUser());
        $tileIds = array_map(fn($hiragana) => $hiragana->getId(), $grid->tiles);

        return $this->redirectToRoute('app_activity_assemblage', [
            'level' => $difficulty->value,
            'session' => $session->getId(),
            'tiles' => implode(',', $tileIds),
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

        return $this->render('activity/assemblage/_result_fragment.html.twig', [
            'result' => $result['result'],
            'xpAmount' => $result['xpAmount'],
            'vocabulary' => $result['vocabulary'],
        ]);
    }

    #[Route('/hiragana/assemblage/terminer', name: 'app_activity_assemblage_terminer', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function terminer(
        Request $request,
        SessionManager $sessionManager,
        XpTransactionRepository $xpTransactionRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $sessionIdParam = $request->request->get('sessionId');
        $session = $sessionManager->getSessionForUser((int) $sessionIdParam, $this->getUser());

        if ($session === null) {
            throw $this->createNotFoundException();
        }

        $sessionManager->closeSession($session);

        $totalXp = $xpTransactionRepository->getTotalXpForSession($session);
        $session->setTotalXp($totalXp);
        $entityManager->flush();

        return $this->json([
            'totalXp' => $totalXp,
        ]);
    }
}
