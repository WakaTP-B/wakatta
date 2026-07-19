<?php

namespace App\Controller;

use App\Enum\DifficultyLevel;
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
    public function vocabulaire(Request $request, QcmGenerator $qcmGenerator, QcmSessionManager $qcmSessionManager): Response
    {
        $levelParam = $request->query->get('level');

        try {
            $difficulty = DifficultyLevel::from($levelParam);
        } catch (\ValueError) {
            $this->addFlash('error', 'Merci de choisir un niveau avant de commencer.');

            return $this->redirectToRoute('app_dashboard');
        }

        $question = $qcmGenerator->generateQuestion($difficulty);

        if (!$question) {
            $this->addFlash('error', 'Aucun mot disponible pour ce niveau.');

            return $this->redirectToRoute('app_dashboard');
        }

        $session = $qcmSessionManager->getOrCreateSession($this->getUser());
        $questionNumber = $qcmSessionManager->getCurrentQuestionNumber($session);

        return $this->render('activity/vocabulaire.html.twig', [
            'question' => $question,
            'questionNumber' => $questionNumber,
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
