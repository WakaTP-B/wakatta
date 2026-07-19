<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Difficulty;
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

    /**
     * Récupère XpRule pour Activity et Difficulty selected
     */
    public function findByActivityAndDifficulty(Activity $activity, Difficulty $difficulty): ?XpRule
    {
        return $this->findOneBy([
            'activity' => $activity,
            'difficulty' => $difficulty,
        ]);
    }
}
