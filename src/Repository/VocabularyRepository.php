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
     * Récupère un Vocabulary random par Difficulty
     *
     * @param string $difficultyName 'facile' | 'moyen' | 'difficile'
     */
    public function findVocabularyByDifficulty(string $difficultyName): ?Vocabulary
    {
        $vocabularies = $this->createQueryBuilder('v')
            ->join('v.difficulty', 'd')
            ->andWhere('d.name = :difficultyName')
            ->setParameter('difficultyName', $difficultyName)
            ->getQuery()
            ->getResult();

        if (empty($vocabularies)) {
            return null;
        }

        return $vocabularies[array_rand($vocabularies)];
    }

    /**
     * Récupère un Vocabulary random pour distracteurs
     * Exclue mot correct
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

        shuffle($vocabularies);

        return array_slice($vocabularies, 0, $count);
    }
}
