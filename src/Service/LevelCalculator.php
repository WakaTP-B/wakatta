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

        // Plancher XP : ne peut pas descendre en dessous du debut du niveau actuel
        // Un niveau acquis ne se perd pas, seule la progression dans le niveau diminue
        $xpEffective = max($xp, $xpCurrentLevelStart);

        $xpCurrentLevel = $xpEffective - $xpCurrentLevelStart;
        $xpNextLevel = $xpRequired - $xpCurrentLevelStart;
        $percent = $xpNextLevel > 0
            ? (int) round(($xpCurrentLevel / $xpNextLevel) * 100)
            : 100;

        // Securite anti-dépassement
        $percent = max(0, min(100, $percent));

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
