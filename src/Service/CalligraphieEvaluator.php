<?php

namespace App\Service;

use App\Entity\ActivityLog;
use App\Entity\User;
use App\Entity\XpTransaction;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CalligraphieEvaluator
{
    // Barème XP fixe
    private const XP_MAP = [
        'rate' => 0,
        'moyen' => 2,
        'reussi' => 4,
    ];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityRepository $activityRepository,
    ) {}

    public function evaluate(User $user, string $result): int
    {
        $xpAmount = self::XP_MAP[$result] ?? 0;
        $activity = $this->activityRepository->findOneBy(['name' => 'Hiragana Calligraphie']);

        $activityLog = new ActivityLog();
        $activityLog->setPlayer($user);
        $activityLog->setActivity($activity);
        $activityLog->setResult($result);
        $activityLog->setCreatedAt(new \DateTimeImmutable());

        $xpTransaction = new XpTransaction();
        $xpTransaction->setPlayer($user);
        $xpTransaction->setActivityLog($activityLog);
        $xpTransaction->setAmount($xpAmount);
        $xpTransaction->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($activityLog);
        $this->entityManager->persist($xpTransaction);
        $this->entityManager->flush();

        return $xpAmount;
    }
}
