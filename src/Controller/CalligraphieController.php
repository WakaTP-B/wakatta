<?php

namespace App\Controller;

use App\Repository\HiraganaRepository;
use App\Service\CalligraphieEvaluator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CalligraphieController extends AbstractController
{
    // Disposition fixe du tableau gojūon (5 colonnes : a/i/u/e/o).
    // null = case vide (combinaison qui n'existe pas en hiragana de base).
    private const GOJUON_GRID = [
        ['a', 'i', 'u', 'e', 'o'],
        ['ka', 'ki', 'ku', 'ke', 'ko'],
        ['sa', 'shi', 'su', 'se', 'so'],
        ['ta', 'chi', 'tsu', 'te', 'to'],
        ['na', 'ni', 'nu', 'ne', 'no'],
        ['ha', 'hi', 'fu', 'he', 'ho'],
        ['ma', 'mi', 'mu', 'me', 'mo'],
        ['ya', null, 'yu', null, 'yo'],
        ['ra', 'ri', 'ru', 're', 'ro'],
        ['wa', null, null, null, 'wo'],
        ['n', null, null, null, null],
    ];

    #[Route('/hiragana/calligraphie', name: 'app_activity_calligraphie')]
    #[IsGranted('ROLE_USER')]
    public function calligraphie(HiraganaRepository $hiraganaRepository): Response
    {
        $hiraganaByRomaji = $hiraganaRepository->findAllIndexedByRomaji();

        return $this->render('activity/calligraphie/index.html.twig', [
            'grid' => self::GOJUON_GRID,
            'hiraganaByRomaji' => $hiraganaByRomaji,
        ]);
    }

    #[Route('/hiragana/calligraphie/aleatoire', name: 'app_activity_calligraphie_aleatoire')]
    #[IsGranted('ROLE_USER')]
    public function calligraphieAleatoire(HiraganaRepository $hiraganaRepository): Response
    {
        $hiraganaByRomaji = $hiraganaRepository->findAllIndexedByRomaji();
        $romajiList = array_keys($hiraganaByRomaji);
        $randomRomaji = $romajiList[array_rand($romajiList)];

        return $this->redirectToRoute('app_activity_calligraphie_pratique', [
            'hiragana' => $randomRomaji,
        ]);
    }

    #[Route('/hiragana/calligraphie/pratique', name: 'app_activity_calligraphie_pratique')]
    #[IsGranted('ROLE_USER')]
    public function calligraphiePratique(Request $request, HiraganaRepository $hiraganaRepository): Response
    {
        $romaji = $request->query->get('hiragana');
        $hiragana = $romaji ? $hiraganaRepository->findOneBy(['romaji' => $romaji]) : null;

        if (!$hiragana) {
            $this->addFlash('error', 'Merci de choisir un hiragana à pratiquer.');

            return $this->redirectToRoute('app_activity_calligraphie');
        }

        return $this->render('activity/calligraphie/practice.html.twig', [
            'hiragana' => $hiragana,
        ]);
    }

    #[Route('/hiragana/calligraphie/evaluation', name: 'app_activity_calligraphie_evaluation')]
    #[IsGranted('ROLE_USER')]
    public function evaluation(Request $request, HiraganaRepository $hiraganaRepository): Response
    {
        $romaji = $request->query->get('hiragana');
        $hiragana = $romaji ? $hiraganaRepository->findOneBy(['romaji' => $romaji]) : null;

        if (!$hiragana) {
            $this->addFlash('error', 'Merci de choisir un hiragana à pratiquer.');

            return $this->redirectToRoute('app_activity_calligraphie');
        }

        return $this->render('activity/calligraphie/evaluation.html.twig', [
            'hiragana' => $hiragana,
        ]);
    }

    #[Route('/hiragana/calligraphie/evaluation/reponse', name: 'app_activity_calligraphie_evaluation_reponse', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function evaluationReponse(Request $request, CalligraphieEvaluator $calligraphieEvaluator): JsonResponse
    {
        $result = $request->request->get('result');
        $xpAmount = $calligraphieEvaluator->evaluate($this->getUser(), $result);

        return $this->json(['xpAmount' => $xpAmount]);
    }
}
