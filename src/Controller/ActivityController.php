<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ActivityController extends AbstractController
{
    #[Route('/vocabulaire', name: 'app_activity_vocabulaire')]
    #[IsGranted('ROLE_USER')]
    public function vocabulaire(): Response
    {
        return $this->render('activity/vocabulaire.html.twig');
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
