<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\ActivityLog;
use App\Entity\Difficulty;
use App\Entity\Session;
use App\Entity\User;
use App\Entity\Vocabulary;
use App\Entity\XpTransaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // User 1 — Iron RAM
        $ironRam = new User();
        $ironRam->setEmail('ironram@mail.com');
        $ironRam->setUsername('Iron RAM');
        $ironRam->setCreatedAt(new \DateTimeImmutable());
        $ironRam->setPassword($this->passwordHasher->hashPassword($ironRam, 'Password123'));
        $manager->persist($ironRam);

        // User 2 — Toto
        $toto = new User();
        $toto->setEmail('tomato@mail.com');
        $toto->setUsername('Toto');
        $toto->setCreatedAt(new \DateTimeImmutable());
        $toto->setPassword($this->passwordHasher->hashPassword($toto, 'Password123'));
        $manager->persist($toto);

        $manager->flush();

        // --- Historique Iron RAM ---

        /** @var Activity $qcm */
        $qcm = $this->getReference('activity-qcm', Activity::class);
        /** @var Activity $calligraphie */
        $calligraphie = $this->getReference('activity-calligraphie', Activity::class);
        /** @var Activity $completion */
        $completion = $this->getReference('activity-completion', Activity::class);
        /** @var Activity $assemblage */
        $assemblage = $this->getReference('activity-assemblage', Activity::class);

        /** @var Difficulty $facile */
        $facile = $this->getReference('difficulty-facile', Difficulty::class);
        /** @var Difficulty $moyen */
        $moyen = $this->getReference('difficulty-moyen', Difficulty::class);
        /** @var Difficulty $difficile */
        $difficile = $this->getReference('difficulty-difficile', Difficulty::class);

        // QCM Facile, réussi, +5
        $this->createActivityLog($manager, $ironRam, $qcm, $facile,
            $this->getReference('vocabulary-neko', Vocabulary::class), 'correct', 5, null);

        // QCM Moyen, réussi, +10
        $this->createActivityLog($manager, $ironRam, $qcm, $moyen,
            $this->getReference('vocabulary-sakana', Vocabulary::class), 'correct', 10, null);

        // QCM Difficile, raté, -8
        $this->createActivityLog($manager, $ironRam, $qcm, $difficile,
            $this->getReference('vocabulary-sakura', Vocabulary::class), 'incorrect', -8, null);

        // Calligraphie, success
        $this->createActivityLog($manager, $ironRam, $calligraphie, null, null, 'success', 4, null);

        // Calligraphie, moyen
        $this->createActivityLog($manager, $ironRam, $calligraphie, null, null, 'medium', 2, null);

        // Complétion Facile, réussi, +5
        $this->createActivityLog($manager, $ironRam, $completion, $facile,
            $this->getReference('vocabulary-hana', Vocabulary::class), 'correct', 5, null);

        // Une Session Assemblage
        $session = new Session();
        $session->setPlayer($ironRam);
        $session->setStartedAt(new \DateTimeImmutable('-10 minutes'));
        $session->setEndedAt(new \DateTimeImmutable('-9 minutes 30 seconds'));
        $manager->persist($session);

        $this->createActivityLog($manager, $ironRam, $assemblage, $moyen,
            $this->getReference('vocabulary-kuruma', Vocabulary::class), 'correct', 10, $session);

        $this->createActivityLog($manager, $ironRam, $assemblage, $facile,
            $this->getReference('vocabulary-neko', Vocabulary::class), 'correct', 5, $session);

        $session->setTotalXp(15);

        $manager->flush();
    }

    private function createActivityLog(
        ObjectManager $manager,
        User $player,
        Activity $activity,
        ?Difficulty $difficulty,
        ?Vocabulary $vocabulary,
        string $result,
        int $xpAmount,
        ?Session $session
    ): void {
        $activityLog = new ActivityLog();
        $activityLog->setPlayer($player);
        $activityLog->setActivity($activity);
        $activityLog->setDifficulty($difficulty);
        $activityLog->setVocabulary($vocabulary);
        $activityLog->setSession($session);
        $activityLog->setResult($result);
        $activityLog->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($activityLog);

        $xpTransaction = new XpTransaction();
        $xpTransaction->setPlayer($player);
        $xpTransaction->setActivityLog($activityLog);
        $xpTransaction->setAmount($xpAmount);
        $xpTransaction->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($xpTransaction);
    }

    public function getDependencies(): array
    {
        return [
            ReferenceDataFixtures::class,
            HiraganaFixtures::class,
            VocabularyFixtures::class,
        ];
    }
}