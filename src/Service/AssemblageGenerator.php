<?php

namespace App\Service;

use App\Dto\AssemblageGrid;
use App\Entity\Hiragana;
use App\Entity\Vocabulary;
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

        // Expansion iterative : mots partageant le maximum d'hiragana
        $vocabularies = $this->selectWordsByExpansion($difficulty, $min, $max);

        if ($vocabularies === null) {
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
     * Selectionne WORDS_PER_GRID mots par expansion iterative du set d'hiragana.
     * Algo : mot pivot aleatoire → cherche mots composables depuis son alphabet →
     * si insuffisant, etend l'alphabet avec un nouveau mot et recommence.
     * Garantit que la grille est dense (tuiles partagees entre plusieurs mots).
     *
     * @return Vocabulary[]|null
     */
    private function selectWordsByExpansion(DifficultyLevel $difficulty, int $min, int $max): ?array
    {
        // Tous les candidats possibles pour cette difficulte
        $candidates = $this->vocabularyRepository->findAllVocabularyByHiraganaLength($min, $max);

        if (count($candidates) < self::WORDS_PER_GRID) {
            return null;
        }

        // Etape 1 : mot pivot aleatoire
        $pivot = $candidates[array_rand($candidates)];

        // Set initial d'hiragana depuis les parts du pivot
        $romajiSet = array_map(
            fn($vh) => $vh->getHiragana()->getRomaji(),
            $pivot->getVocabularyHiraganas()->toArray()
        );

        $selectedWords = [$pivot];
        $excludeIds = [$pivot->getId()];

        // Expansion iterative, securite anti-boucle infinie
        $maxIterations = 20;
        $iterations = 0;

        while (count($selectedWords) < self::WORDS_PER_GRID && $iterations < $maxIterations) {
            $iterations++;

            // Cherche les mots composables depuis le set d'hiragana actuel
            $composable = $this->vocabularyRepository->findVocabularyComposableFrom(
                $romajiSet,
                $min,
                $max
            );

            // Retire ceux deja selectionnes
            $composable = array_values(array_filter(
                $composable,
                fn($v) => !in_array($v->getId(), $excludeIds, true)
            ));

            if (!empty($composable)) {
                // Prend un mot composable au hasard
                $next = $composable[array_rand($composable)];
                $selectedWords[] = $next;
                $excludeIds[] = $next->getId();
            } else {
                // Plus de mots composables -> expansion du set avec un nouveau mot
                $remaining = array_values(array_filter(
                    $candidates,
                    fn($v) => !in_array($v->getId(), $excludeIds, true)
                ));

                // pas assez de vocabulaire
                if (empty($remaining)) {
                    return null;
                }

                $expansion = $remaining[array_rand($remaining)];
                $excludeIds[] = $expansion->getId();

                // Etend le set d'hiragana avec les parts du mot d'expansion
                $newRomaji = array_map(
                    fn($vh) => $vh->getHiragana()->getRomaji(),
                    $expansion->getVocabularyHiraganas()->toArray()
                );
                $romajiSet = array_unique(array_merge($romajiSet, $newRomaji));

                // Ce mot d'expansion compte aussi comme mot selectionne
                $selectedWords[] = $expansion;
            }
        }

        if (count($selectedWords) < self::WORDS_PER_GRID) {
            return null;
        }

        return $selectedWords;
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
