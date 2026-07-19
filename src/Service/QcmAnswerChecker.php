<?php

namespace App\Service;

use App\Entity\ActivityLog;
use App\Entity\Session;
use App\Entity\User;
use App\Entity\Vocabulary;
use App\Entity\XpTransaction;
use App\Enum\DifficultyLevel;
use App\Repository\ActivityRepository;
use App\Repository\DifficultyRepository;
use App\Repository\XpRuleRepository;
use Doctrine\ORM\EntityManagerInterface;

final class QcmAnswerChecker
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityRepository $activityRepository,
        private readonly DifficultyRepository $difficultyRepository,
        private readonly XpRuleRepository $xpRuleRepository,
    ) {
    }

    /**
     * Check la réponse donnée par le joueur, enregistre le résultat en BDD
     * (ActivityLog + XpTransaction) et retourne si c'était correct + l'XP gagné/perdu.
     *
     * @return array{isCorrect: bool, xpAmount: int}
     */
    public function checkAnswer(
        User $user,
        Vocabulary $vocabulary,
        DifficultyLevel $difficulty,
        string $submittedAnswer,
        Session $session,
    ): array {
        // Check la réponse directement en BDD
        $correctAnswer = $difficulty === DifficultyLevel::FACILE
            ? $vocabulary->getFrench()
            : $vocabulary->getHiragana();

        $isCorrect = $submittedAnswer === $correctAnswer;

        // On récupère  Activity / Difficulty / XpRule
        $activity = $this->activityRepository->findOneBy(['name' => 'QCM Vocabulaire']);
        $difficultyEntity = $this->difficultyRepository->findOneBy(['name' => $difficulty->value]);
        $xpRule = $this->xpRuleRepository->findByActivityAndDifficulty($activity, $difficultyEntity);

        $xpAmount = $isCorrect ? $xpRule->getXpSuccess() : $xpRule->getXpFailure();

        // Création ActivityLog
        $activityLog = new ActivityLog();
        $activityLog->setPlayer($user);
        $activityLog->setActivity($activity);
        $activityLog->setVocabulary($vocabulary);
        $activityLog->setDifficulty($difficultyEntity);
        $activityLog->setSession($session);
        $activityLog->setResult($isCorrect ? 'success' : 'failure');
        $activityLog->setCreatedAt(new \DateTimeImmutable());

        // Création XpTransaction
        $xpTransaction = new XpTransaction();
        $xpTransaction->setPlayer($user);
        $xpTransaction->setActivityLog($activityLog);
        $xpTransaction->setAmount($xpAmount);
        $xpTransaction->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($activityLog);
        $this->entityManager->persist($xpTransaction);
        $this->entityManager->flush();

        return [
            'isCorrect' => $isCorrect,
            'xpAmount' => $xpAmount,
            'correctAnswer' => $correctAnswer,
        ];
    }
}