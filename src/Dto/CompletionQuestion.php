<?php

namespace App\Dto;

use App\Entity\Hiragana;
use App\Entity\Vocabulary;
use App\Enum\DifficultyLevel;

final class CompletionQuestion
{
    /**
     * @param Hiragana[] $blanks Les hiragana corrects, dans l'ordre du mot
     * @param Hiragana[] $choices Tous les hiragana proposés (corrects + distracteurs), mélangés
     */
    public function __construct(
        public readonly Vocabulary $vocabulary,
        public readonly DifficultyLevel $difficulty,
        public readonly bool $showRomaji,
        public readonly array $blanks,
        public readonly array $choices,
    ) {
    }
}