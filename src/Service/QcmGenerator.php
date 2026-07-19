<?php

namespace App\Service;

use App\Dto\QcmQuestion;
use App\Entity\Vocabulary;
use App\Enum\DifficultyLevel;
use App\Repository\VocabularyRepository;

final class QcmGenerator
{
    public function __construct(
        private readonly VocabularyRepository $vocabularyRepository,
    ) {}

    public function generateQuestion(DifficultyLevel $difficulty, array $excludedVocabularyIds = []): ?QcmQuestion
    {
        $vocabulary = $this->vocabularyRepository->findVocabularyByDifficulty($difficulty->value, $excludedVocabularyIds);

        if (!$vocabulary) {
            return null;
        }

        $distractors = $this->vocabularyRepository->findDistractors($vocabulary);

        return match ($difficulty) {
            DifficultyLevel::FACILE => $this->buildFrenchChoiceQuestion($vocabulary, $distractors, $difficulty),
            DifficultyLevel::MOYEN, DifficultyLevel::DIFFICILE => $this->buildHiraganaChoiceQuestion($vocabulary, $distractors, $difficulty),
        };
    }

    private function buildFrenchChoiceQuestion(Vocabulary $vocabulary, array $distractors, DifficultyLevel $difficulty): QcmQuestion
    {
        $choices = array_map(fn(Vocabulary $v) => $v->getFrench(), $distractors);
        $choices[] = $vocabulary->getFrench();
        shuffle($choices);

        return new QcmQuestion(
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            choices: $choices,
            correctAnswer: $vocabulary->getFrench(),
        );
    }

    private function buildHiraganaChoiceQuestion(Vocabulary $vocabulary, array $distractors, DifficultyLevel $difficulty): QcmQuestion
    {
        $choices = array_map(fn(Vocabulary $v) => $v->getHiragana(), $distractors);
        $choices[] = $vocabulary->getHiragana();
        shuffle($choices);

        return new QcmQuestion(
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            choices: $choices,
            correctAnswer: $vocabulary->getHiragana(),
        );
    }

    /**
     * Reconstruit une question à partir d'une liste de choix déjà fixée
     * (utilisé au rechargement de page, pour que les distracteurs ne changent pas - sinon un joueur pourrait repérer la bonne réponse en comparant plusieurs reloads).
     *
     * @param string[] $choices
     */
    public function buildQuestionFromFixedChoices(Vocabulary $vocabulary, DifficultyLevel $difficulty, array $choices): QcmQuestion
    {
        $correctAnswer = $difficulty === DifficultyLevel::FACILE
            ? $vocabulary->getFrench()
            : $vocabulary->getHiragana();

        return new QcmQuestion(
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            choices: $choices,
            correctAnswer: $correctAnswer,
        );
    }
}
