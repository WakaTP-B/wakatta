<?php

namespace App\Service;

use App\Dto\CompletionQuestion;
use App\Entity\Hiragana;
use App\Entity\Vocabulary;
use App\Enum\DifficultyLevel;
use App\Repository\HiraganaGroupRepository;
use App\Repository\HiraganaRepository;
use App\Repository\VocabularyRepository;

final class CompletionGenerator
{
    // Nombre de distracteurs
    private const DISTRACTOR_COUNT = 4;

    public function __construct(
        private readonly VocabularyRepository $vocabularyRepository,
        private readonly HiraganaRepository $hiraganaRepository,
        private readonly HiraganaGroupRepository $hiraganaGroupRepository,
    ) {}

    public function generateQuestion(DifficultyLevel $difficulty, array $excludedVocabularyIds = []): ?CompletionQuestion
    {
        $vocabulary = $this->vocabularyRepository->findVocabularyByDifficulty($difficulty->value, $excludedVocabularyIds);

        if (!$vocabulary) {
            return null;
        }

        return $this->buildQuestionForVocabulary($vocabulary, $difficulty);
    }

    public function buildQuestionForVocabulary(Vocabulary $vocabulary, DifficultyLevel $difficulty): CompletionQuestion
    {
        // Les hiragana corrects, dans l'ordre du mot (grâce à VocabularyHiragana::position)
        $vocabularyHiraganas = $vocabulary->getVocabularyHiraganas()->toArray();
        usort($vocabularyHiraganas, fn($a, $b) => $a->getPosition() <=> $b->getPosition());

        $blanks = array_map(fn($vh) => $vh->getHiragana(), $vocabularyHiraganas);
        $correctIds = array_map(fn(Hiragana $h) => $h->getId(), $blanks);

        $distractors = $difficulty === DifficultyLevel::DIFFICILE
            ? $this->findVisualDistractors($blanks, $correctIds)
            : $this->hiraganaRepository->findRandomExcluding($correctIds, self::DISTRACTOR_COUNT);

        $choices = array_merge($blanks, $distractors);
        shuffle($choices);

        return new CompletionQuestion(
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            showRomaji: $difficulty === DifficultyLevel::FACILE,
            blanks: $blanks,
            choices: $choices,
        );
    }

    /**
     * Pour le niveau Difficile : cherche des hiragana visuellement proches de chaque hiragana correct du mot, complète avec du random si besoin.
     *
     * @param Hiragana[] $blanks
     * @param int[] $correctIds
     * @return Hiragana[]
     */
    private function findVisualDistractors(array $blanks, array $correctIds): array
    {
        $distractors = [];

        foreach ($blanks as $hiragana) {
            $similar = $this->hiraganaGroupRepository->findVisuallySimilar($hiragana, 2);
            foreach ($similar as $candidate) {
                if (!in_array($candidate->getId(), $correctIds, true)) {
                    $distractors[$candidate->getId()] = $candidate;
                }
            }
        }

        $distractors = array_values($distractors);

        // Si pas assez de distracteurs, on complète avec du random
        if (count($distractors) < self::DISTRACTOR_COUNT) {
            $excludeIds = array_merge($correctIds, array_map(fn(Hiragana $h) => $h->getId(), $distractors));
            $filler = $this->hiraganaRepository->findRandomExcluding($excludeIds, self::DISTRACTOR_COUNT - count($distractors));
            $distractors = array_merge($distractors, $filler);
        }

        shuffle($distractors);

        return array_slice($distractors, 0, self::DISTRACTOR_COUNT);
    }

    /**
     * Reconstruit une question à partir d'une liste de choix déjà fixée
     *
     * @param int[] $choiceHiraganaIds
     */
    public function buildQuestionFromFixedChoices(Vocabulary $vocabulary, DifficultyLevel $difficulty, array $choiceHiraganaIds): CompletionQuestion
    {
        $vocabularyHiraganas = $vocabulary->getVocabularyHiraganas()->toArray();
        usort($vocabularyHiraganas, fn($a, $b) => $a->getPosition() <=> $b->getPosition());
        $blanks = array_map(fn($vh) => $vh->getHiragana(), $vocabularyHiraganas);

        $choices = $this->hiraganaRepository->findByIdsPreservingOrder($choiceHiraganaIds);

        return new CompletionQuestion(
            vocabulary: $vocabulary,
            difficulty: $difficulty,
            showRomaji: $difficulty === DifficultyLevel::FACILE,
            blanks: $blanks,
            choices: $choices,
        );
    }
}
