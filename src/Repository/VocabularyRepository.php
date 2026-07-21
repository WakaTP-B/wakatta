<?php

namespace App\Repository;

use App\Entity\Vocabulary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vocabulary>
 */
class VocabularyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vocabulary::class);
    }

    /**
     * Récupère un Vocabulary aléatoire par Difficulty.
     * $excludeIds permet d'éviter de retirer un mot déjà tombé dans la série en cours.
     *
     * @param int[] $excludeIds
     * @return Vocabulary|null Null si aucun mot n'existe pour cette difficulté
     */
    public function findVocabularyByDifficulty(string $difficultyName, array $excludeIds = []): ?Vocabulary
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->join('v.difficulty', 'd')
            ->andWhere('d.name = :difficultyName')
            ->setParameter('difficultyName', $difficultyName);

        if (!empty($excludeIds)) {
            $queryBuilder->andWhere('v.id NOT IN (:excludeIds)')
                ->setParameter('excludeIds', $excludeIds);
        }

        $vocabularies = $queryBuilder->getQuery()->getResult();

        if (empty($vocabularies)) {
            return null;
        }

        return $vocabularies[array_rand($vocabularies)];
    }


    /**
     * Récupère un Vocabulary random pour distracteurs
     * Exclue mot correct, préviligie mots avec meme nbr de caractères
     *
     * @param Vocabulary $exclude Vocabulary (la bonne réponse)
     * @param int $count Nombre de fakes
     * @return Vocabulary[]
     */
    public function findDistractors(Vocabulary $exclude, int $count = 3): array
    {
        $vocabularies = $this->createQueryBuilder('v')
            ->join('v.difficulty', 'd')
            ->andWhere('d.name = :difficultyName')
            ->andWhere('v.id != :excludeId')
            ->setParameter('difficultyName', $exclude->getDifficulty()->getName())
            ->setParameter('excludeId', $exclude->getId())
            ->getQuery()
            ->getResult();

        $targetLength = mb_strlen($exclude->getHiragana());

        $sameLength = array_values(array_filter(
            $vocabularies,
            fn(Vocabulary $v) => mb_strlen($v->getHiragana()) === $targetLength
        ));
        shuffle($sameLength);
        $distractors = array_slice($sameLength, 0, $count);

        // Si pas assez de mots de la même longueur, on complète avec les autres
        if (count($distractors) < $count) {
            $usedIds = array_map(fn(Vocabulary $v) => $v->getId(), $distractors);
            $others = array_values(array_filter(
                $vocabularies,
                fn(Vocabulary $v) => !in_array($v->getId(), $usedIds, true)
            ));
            shuffle($others);
            $distractors = array_merge($distractors, array_slice($others, 0, $count - count($distractors)));
        }

        return $distractors;
    }
}
