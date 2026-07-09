<?php

namespace App\Repository;

use App\Entity\XpRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XpRule>
 */
class XpRuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XpRule::class);
    }

    //    /**
    //     * @return XpRule[] Returns an array of XpRule objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('x')
    //            ->andWhere('x.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('x.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?XpRule
    //    {
    //        return $this->createQueryBuilder('x')
    //            ->andWhere('x.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
