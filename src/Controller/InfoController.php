<?php

namespace App\Controller;

use App\Repository\HiraganaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class InfoController extends AbstractController
{
    // Disposition fixe du tableau gojūon (5 colonnes : a/i/u/e/o).
    // null = case vide (combinaison qui n'existe pas en hiragana de base).
    // Duplique CalligraphieController::GOJUON_GRID - simple consultation
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

    #[Route('/hiragana/alphabet', name: 'app_info_alphabet')]
    #[IsGranted('ROLE_USER')]
    public function alphabet(HiraganaRepository $hiraganaRepository): Response
    {
        $hiraganaByRomaji = $hiraganaRepository->findAllIndexedByRomaji();

        return $this->render('info/alphabet.html.twig', [
            'grid' => self::GOJUON_GRID,
            'hiraganaByRomaji' => $hiraganaByRomaji,
        ]);
    }
}