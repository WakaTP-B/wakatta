<?php

namespace App\Service;

use App\Dto\AssemblageGrid;
use App\Entity\Hiragana;
use App\Enum\DifficultyLevel;
use App\Repository\HiraganaGroupRepository;
use App\Repository\HiraganaRepository;
use App\Repository\VocabularyRepository;

final class AssemblageGenerator
{
    // Nombre de Vocabulary pour une session
    private const WORDS_PER_GRID = 5;

    // Longueur Vocabulary (nombre d'hiragana) par difficulté
    private const LENGTH_RANGES = [
        'facile' => [2, 3],
        'moyen' => [3, 4],
        'difficile' => [4, 5],
    ];

    // Nombre de distraceurs, par difficulté
    private const DISTRACTOR_COUNT = [
        'facile' => 0,
        'moyen' => 4,
        'difficile' => 8,
    ];

    
    public function __construct(
        private readonly VocabularyRepository $vocabularyRepository,
        private readonly HiraganaRepository $hiraganaRepository,
        private readonly HiraganaGroupRepository $hiraganaGroupRepository,
    ) {}

    public function generateGrid(DifficultyLevel $difficulty): ?AssemblageGrid
    {
        [$min, $max] = self::LENGTH_RANGES[$difficulty->value];

        // Tirage des Vocabulary, sans doublons
        $vocabularies = [];
        $excludeIds = [];
        for ($i = 0; $i < self::WORDS_PER_GRID; $i++) {
            $vocabulary = $this->vocabularyRepository->findVocabularyByHiraganaLength($min, $max, $excludeIds);

            // if épuisé, on stop
            if ($vocabulary === null) {
                break;
            }

            $vocabularies[] = $vocabulary;
            $excludeIds[] = $vocabulary->getId();
        }

        if (empty($vocabularies)) {
            return null;
        }

        // Regroupe les hiragana de tous les Vocabulary, l'id en key pour les doublons
        $correctTiles = [];
        foreach ($vocabularies as $vocabulary) {
            foreach ($vocabulary->getVocabularyHiraganas() as $vh) {
                $hiragana = $vh->getHiragana();
                $correctTiles[$hiragana->getId()] = $hiragana;
            }
        }
        $correctIds = array_keys($correctTiles);

        // Distracteurs selon le niveau
        $distractorCount = self::DISTRACTOR_COUNT[$difficulty->value];
        $distractors = $difficulty === DifficultyLevel::DIFFICILE
            ? $this->findVisualDistractors(array_values($correctTiles), $correctIds, $distractorCount)
            : $this->hiraganaRepository->findRandomExcluding($correctIds, $distractorCount);

        // Grille finale mélangée
        $tiles = array_merge(array_values($correctTiles), $distractors);
        shuffle($tiles);

        return new AssemblageGrid(
            difficulty: $difficulty,
            showRomaji: $difficulty === DifficultyLevel::FACILE,
            tiles: $tiles,
        );
    }

    /**
     * Reconstruit la grille à l'identique à partir d'une liste d'ids figée (anti-triche URL).
     *
     * @param int[] $tileHiraganaIds
     */
    public function buildGridFromFixedTiles(DifficultyLevel $difficulty, array $tileHiraganaIds): AssemblageGrid
    {
        return new AssemblageGrid(
            difficulty: $difficulty,
            showRomaji: $difficulty === DifficultyLevel::FACILE,
            tiles: $this->hiraganaRepository->findByIdsPreservingOrder($tileHiraganaIds),
        );
    }

    /**
     * Pour le niveau Difficile : cherche des hiragana visuellement proches de chaque hiragana correct, complète avec du random si besoin.
     *
     * @param Hiragana[] $correctTiles
     * @param int[] $correctIds
     * @return Hiragana[]
     */
    private function findVisualDistractors(array $correctTiles, array $correctIds, int $count): array
    {
        $distractors = [];

        foreach ($correctTiles as $hiragana) {
            $similar = $this->hiraganaGroupRepository->findVisuallySimilar($hiragana, 2);
            foreach ($similar as $candidate) {
                if (!in_array($candidate->getId(), $correctIds, true)) {
                    $distractors[$candidate->getId()] = $candidate;
                }
            }
        }

        $distractors = array_values($distractors);

        if (count($distractors) < $count) {
            $excludeIds = array_merge($correctIds, array_map(fn(Hiragana $h) => $h->getId(), $distractors));
            $filler = $this->hiraganaRepository->findRandomExcluding($excludeIds, $count - count($distractors));
            $distractors = array_merge($distractors, $filler);
        }

        shuffle($distractors);

        return array_slice($distractors, 0, $count);
    }
}
