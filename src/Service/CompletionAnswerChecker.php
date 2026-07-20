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

final class CompletionAnswerChecker
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityRepository $activityRepository,
        private readonly DifficultyRepository $difficultyRepository,
        private readonly XpRuleRepository $xpRuleRepository,
    ) {}

    /**
     * Vérifie la séquence de hiragana soumise, enregistre le résultat en BDD
     *
     * @param int[] $submittedHiraganaIds La séquence proposée par le joueur, dans l'ordre cliqué
     * @return array{isCorrect: bool, xpAmount: int}
     */
    public function checkAnswer(
        User $user,
        Vocabulary $vocabulary,
        DifficultyLevel $difficulty,
        array $submittedHiraganaIds,
        Session $session,
    ): array {
        $vocabularyHiraganas = $vocabulary->getVocabularyHiraganas()->toArray();
        usort($vocabularyHiraganas, fn($a, $b) => $a->getPosition() <=> $b->getPosition());
        $correctIds = array_map(fn($vh) => $vh->getHiragana()->getId(), $vocabularyHiraganas);

        $isCorrect = $submittedHiraganaIds === $correctIds;

        $activity = $this->activityRepository->findOneBy(['name' => 'Hiragana Complétion']);
        $difficultyEntity = $this->difficultyRepository->findOneBy(['name' => $difficulty->value]);
        $xpRule = $this->xpRuleRepository->findByActivityAndDifficulty($activity, $difficultyEntity);

        $xpAmount = $isCorrect ? $xpRule->getXpSuccess() : $xpRule->getXpFailure();

        $activityLog = new ActivityLog();
        $activityLog->setPlayer($user);
        $activityLog->setActivity($activity);
        $activityLog->setVocabulary($vocabulary);
        $activityLog->setDifficulty($difficultyEntity);
        $activityLog->setSession($session);
        $activityLog->setResult($isCorrect ? 'success' : 'failure');
        $activityLog->setCreatedAt(new \DateTimeImmutable());

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
            'correctWord' => $vocabulary->getHiragana(),
        ];
    }
}
