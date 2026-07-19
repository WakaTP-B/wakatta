<?php

namespace App\Dto;

use App\Entity\Vocabulary;
use App\Enum\DifficultyLevel;

final class QcmQuestion
{
    /**
     * @param Vocabulary $vocabulary Vocabulary correct (la bonne réponse)
     * @param DifficultyLevel $difficulty Niveau de Difficulty
     * @param string[] $choices Les propositions affichées (mélangées, contient la bonne réponse)
     * @param string $correctAnswer La bonne réponse, doit matcher une valeur de $choices
     */
    public function __construct(
        public readonly Vocabulary $vocabulary,
        public readonly DifficultyLevel $difficulty,
        public readonly array $choices,
        public readonly string $correctAnswer,
    ) {
    }
}