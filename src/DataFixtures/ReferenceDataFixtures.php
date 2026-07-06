<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Difficulty;
use App\Entity\LevelSettings;
use App\Entity\XpRule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReferenceDataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // levelSettings
        $levelSettings = new LevelSettings();
        $levelSettings->setBaseXp(100);
        $levelSettings->setIncrement(50);
        $manager->persist($levelSettings);

        // Difficulty
        $difficulties = [
            'facile' => ['name' => 'facile', 'labelJp' => 'かんたん'],
            'moyen' => ['name' => 'moyen', 'labelJp' => 'ふつう'],
            'difficile' => ['name' => 'difficile', 'labelJp' => 'むずかしい'],
        ];

        $difficultyEntities = [];
        foreach ($difficulties as $key => $data) {
            $difficulty = new Difficulty();
            $difficulty->setName($data['name']);
            $difficulty->setLabelJp($data['labelJp']);
            $manager->persist($difficulty);
            $this->addReference('difficulty-' . $key, $difficulty);
            $difficultyEntities[$key] = $difficulty;
        }

        // Activity
        $activities = [
            'qcm' => 'QCM Vocabulaire',
            'calligraphie' => 'Hiragana Calligraphie',
            'completion' => 'Hiragana Complétion',
            'assemblage' => 'Hiragana Assemblage',
        ];

        $activityEntities = [];
        foreach ($activities as $key => $name) {
            $activity = new Activity();
            $activity->setName($name);
            $manager->persist($activity);
            $this->addReference('activity-' . $key, $activity);
            $activityEntities[$key] = $activity;
        }

        // XpRule
        $baremes = [
            'facile' => ['success' => 5, 'failure' => -2],
            'moyen' => ['success' => 10, 'failure' => -4],
            'difficile' => ['success' => 15, 'failure' => -8],
        ];

        foreach (['qcm', 'completion', 'assemblage'] as $activityKey) {
            foreach ($baremes as $difficultyKey => $xp) {
                $xpRule = new XpRule();
                $xpRule->setActivity($activityEntities[$activityKey]);
                $xpRule->setDifficulty($difficultyEntities[$difficultyKey]);
                $xpRule->setXpSuccess($xp['success']);
                $xpRule->setXpFailure($xp['failure']);
                $manager->persist($xpRule);
            }
        }
        $manager->flush();
    }
}
