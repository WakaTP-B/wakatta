<?php

namespace App\Service;

use App\Repository\LevelSettingsRepository;

class LevelCalculator
{
    public function __construct(
        private LevelSettingsRepository $levelSettingsRepository
    ) {
    }

    public function calculerNiveau(int $xp): int
    {
        $levelSettings = $this->levelSettingsRepository->findOneBy([]);

        $niveau = 1;
        $seuil = $levelSettings->getBaseXp();
        $paletteIncrement = $levelSettings->getBaseXp() + $levelSettings->getIncrement();

        while ($xp >= $seuil) {
            $niveau++;
            $seuil += $paletteIncrement;
            $paletteIncrement += $levelSettings->getIncrement();
        }

        return $niveau;
    }
}