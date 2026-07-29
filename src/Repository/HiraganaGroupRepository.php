<?php

namespace App\Repository;

use App\Entity\Hiragana;
use App\Entity\HiraganaGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HiraganaGroup>
 */
class HiraganaGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HiraganaGroup::class);
    }
    /**
     * Trouve les hiragana visuellement proches d'un hiragana donné
     * (même groupe de type 'visual'), en excluant le hiragana lui-même.
     *
     * @return Hiragana[]
     */
    public function findVisuallySimilar(Hiragana $hiragana, int $count = 3): array
    {
        $groups = $this->createQueryBuilder('g')
            ->join('g.hiraganaGroupMembers', 'm')
            ->andWhere('g.type = :type')
            ->andWhere('m.hiragana = :hiragana')
            ->setParameter('type', 'visual')
            ->setParameter('hiragana', $hiragana)
            ->getQuery()
            ->getResult();

        $similar = [];
        foreach ($groups as $group) {
            foreach ($group->getHiraganaGroupMembers() as $member) {
                $candidate = $member->getHiragana();
                if ($candidate->getId() !== $hiragana->getId()) {
                    $similar[$candidate->getId()] = $candidate;
                }
            }
        }

        $similar = array_values($similar);
        shuffle($similar);

        return array_slice($similar, 0, $count);
    }

}
