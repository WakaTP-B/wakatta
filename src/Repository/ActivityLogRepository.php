<?php

namespace App\Repository;

use App\Entity\ActivityLog;
use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActivityLog>
 */
class ActivityLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityLog::class);
    }

    /**
     * Count attempt / session
     */
    public function countForSession(Session $session): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.session = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * Count bonnes réponses / session
     */
    public function countSuccessForSession(Session $session): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.session = :session')
            ->andWhere('a.result = :result')
            ->setParameter('session', $session)
            ->setParameter('result', 'success')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Récupère les ids des mots déjà posés dans cette session, pour éviter les doublons.
     *
     * @return int[]
     */
    public function findVocabularyIdsForSession(Session $session): array
    {
        $result = $this->createQueryBuilder('a')
            ->select('IDENTITY(a.vocabulary) as vocabularyId')
            ->andWhere('a.session = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->getResult();

        return array_column($result, 'vocabularyId');
    }
}
