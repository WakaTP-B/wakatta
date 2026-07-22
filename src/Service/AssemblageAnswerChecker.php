<?php

namespace App\Service;

use App\Entity\ActivityLog;
use App\Entity\Session;
use App\Entity\User;
use App\Entity\XpTransaction;
use App\Entity\Vocabulary;
use App\Enum\DifficultyLevel;
use App\Repository\ActivityLogRepository;
use App\Repository\ActivityRepository;
use App\Repository\DifficultyRepository;
use App\Repository\HiraganaRepository;
use App\Repository\VocabularyRepository;
use App\Repository\XpRuleRepository;
use Doctrine\ORM\EntityManagerInterface;

final class AssemblageAnswerChecker
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ActivityRepository $activityRepository,
        private readonly DifficultyRepository $difficultyRepository,
        private readonly XpRuleRepository $xpRuleRepository,
        private readonly VocabularyRepository $vocabularyRepository,
        private readonly HiraganaRepository $hiraganaRepository,
        private readonly ActivityLogRepository $activityLogRepository,
    ) {}

    /**
     * Rebuild le mot depuis les hiragana select, check si ca match un Vocabulary enregistre le resultat (ActivityLog + XpTransaction) et retourne le resultat.
     *
     * @param int[] $selectedHiraganaIds Ids des hiragana, dans l'ordre de sélection du joueur
     * @return array{result: string, xpAmount: int, vocabulary: ?Vocabulary}
     */
    public function checkAnswer(
        User $user,
        array $selectedHiraganaIds,
        DifficultyLevel $difficulty,
        Session $session,
    ): array {
        // Rebuild le mot depuis depuis la selection du joueur
        $selectedHiraganas = $this->hiraganaRepository->findByIdsPreservingOrder($selectedHiraganaIds);
        $submittedString = implode('', array_map(fn($h) => $h->getCharacter(), $selectedHiraganas));

        $vocabulary = $this->vocabularyRepository->findVocabularyByHiraganaString($submittedString);

        // Check si le mot match un Vocabulary, et si oui, check si déja trouvé dans cette session
        if ($vocabulary === null) {
            $result = 'failure';
        } elseif ($this->activityLogRepository->countSuccessForVocabularyInSession($session, $vocabulary) > 0) {
            $result = 'already_found';
        } else {
            $result = 'success';
        }

        // On récupère Activity / Difficulty / XpRule
        $activity = $this->activityRepository->findOneBy(['name' => 'Hiragana Assemblage']);
        $difficultyEntity = $this->difficultyRepository->findOneBy(['name' => $difficulty->value]);
        $xpRule = $this->xpRuleRepository->findByActivityAndDifficulty($activity, $difficultyEntity);

        $xpAmount = $result === 'success' ? $xpRule->getXpSuccess() : $xpRule->getXpFailure();

        // Création ActivityLog, pour garder un historique (pattern ledger)
        $activityLog = new ActivityLog();
        $activityLog->setPlayer($user);
        $activityLog->setActivity($activity);
        $activityLog->setVocabulary($vocabulary);
        $activityLog->setDifficulty($difficultyEntity);
        $activityLog->setSession($session);
        $activityLog->setResult($result);
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
            'result' => $result,
            'xpAmount' => $xpAmount,
            'vocabulary' => $vocabulary,
        ];
    }
}
