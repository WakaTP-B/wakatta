<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\XpTransactionRepository;
use App\Service\LevelCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashboardController extends AbstractController
{
    /**
     * Mapping "nom en base" -> "libellé affiché" + "route du module".
     */
    private const MODULE_LABELS = [
        'QCM Vocabulaire' => [
            'label' => 'Vocabulaire',
            'route' => 'app_activity_vocabulaire',
            'availableDifficulties' => ['facile', 'moyen', 'difficile'],
        ],
        'Hiragana Calligraphie' => [
            'label' => 'Hiragana - Calligraphie',
            'route' => 'app_activity_calligraphie',
            'availableDifficulties' => [],
        ],
        'Hiragana Complétion' => [
            'label' => 'Hiragana - Complétion',
            'route' => 'app_activity_completion',
            'availableDifficulties' => ['facile', 'moyen', 'difficile'],
        ],
        'Hiragana Assemblage' => [
            'label' => 'Hiragana - Assemblage',
            'route' => 'app_activity_assemblage',
            'availableDifficulties' => ['facile', 'moyen', 'difficile'],
        ],
    ];

    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function index(
        XpTransactionRepository $xpTransactionRepository,
        ActivityRepository $activityRepository,
        LevelCalculator $levelCalculator,
    ): Response {
        $user = $this->getUser();

        $xpTotal = $xpTransactionRepository->getTotalXpForUser($user);
        $globalProgression = $levelCalculator->calculProgress($xpTotal);

        $modules = [];
        foreach ($activityRepository->findAll() as $activity) {
            $config = self::MODULE_LABELS[$activity->getName()] ?? [
                'label' => $activity->getName(),
                'route' => null,
            ];

            $xpForActivity = $xpTransactionRepository->getTotalXpActivityForUser($user, $activity);

            $modules[] = [
                'label' => $config['label'],
                'route' => $config['route'],
                'availableDifficulties' => $config['availableDifficulties'] ?? [],
                'progression' => $levelCalculator->calculProgress($xpForActivity),
            ];
        }

        return $this->render('dashboard/index.html.twig', [
            'globalProgression' => $globalProgression,
            'modules' => $modules,
        ]);
    }
}
