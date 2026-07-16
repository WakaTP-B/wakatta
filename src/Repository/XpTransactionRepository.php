<?php

namespace App\Repository;

use App\Entity\XpTransaction;
use App\Entity\User;
use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XpTransaction>
 */
class XpTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XpTransaction::class);
    }

    public function getTotalXpForUser(User $user): int
    {
        return (int) $this->createQueryBuilder('xt')
            ->select('COALESCE(SUM(xt.amount), 0)')
            ->where('xt.player = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalXpActivityForUser(User $user, Activity $activity): int
    {
        return (int) $this->createQueryBuilder('xt')
            ->select('COALESCE(SUM(xt.amount), 0)')
            ->join('xt.activityLog', 'al')
            ->where('xt.player = :user')
            ->andWhere('al.activity = :activity')
            ->setParameter('user', $user)
            ->setParameter('activity', $activity)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
