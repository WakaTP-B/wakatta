<?php

namespace App\Dto;

use App\Entity\Hiragana;
use App\Enum\DifficultyLevel;

final class AssemblageGrid
{
    /**
     * @param Hiragana[] $tiles Grille (hiragana des mots + leurres)
     */
    public function __construct(
        public readonly DifficultyLevel $difficulty,
        public readonly bool $showRomaji,
        public readonly array $tiles,
    ) {}
}