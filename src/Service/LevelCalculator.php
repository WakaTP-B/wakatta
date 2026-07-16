<?php

namespace App\Service;

use App\Repository\LevelSettingsRepository;

class LevelCalculator
{
    public function __construct(
        private LevelSettingsRepository $levelSettingsRepository
    ) {}

    public function calculProgress(int $xp): array
    {
        $levelSettings = $this->levelSettingsRepository->findOneBy([]);

        $level = 1;
        $xpCurrentLevelStart = 0;
        $xpRequired = $levelSettings->getBaseXp();
        $xpStep = $levelSettings->getBaseXp() + $levelSettings->getIncrement();

        while ($xp >= $xpRequired) {
            $level++;
            $xpCurrentLevelStart = $xpRequired;
            $xpRequired += $xpStep;
            $xpStep += $levelSettings->getIncrement();
        }

        $xpCurrentLevel = $xp - $xpCurrentLevelStart;
        $xpNextLevel = $xpRequired - $xpCurrentLevelStart;
        $percent = $xpNextLevel > 0
            ? (int) round(($xpCurrentLevel / $xpNextLevel) * 100)
            : 100;

        return [
            'level' => $level,
            'xpTotal' => $xp,
            'xpCurrentLevel' => $xpCurrentLevel,
            'xpNextLevel' => $xpNextLevel,
            'percent' => $percent,
        ];
    }


    public function calculLevel(int $xp): int
    {
        return $this->calculProgress($xp)['level'];
    }
}
