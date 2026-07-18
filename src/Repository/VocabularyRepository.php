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
}
