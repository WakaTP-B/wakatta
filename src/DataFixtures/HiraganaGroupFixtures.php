<?php

namespace App\DataFixtures;

use App\Entity\Hiragana;
use App\Entity\HiraganaGroup;
use App\Entity\HiraganaGroupMember;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HiraganaGroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Regroupements classiques d'hiragana visuellement proches, utilisés pour distracteurs "difficiles" en Complétion
        $visualGroups = [
            'visual-nu-me-ne' => ['nu', 'me', 'ne'],
            'visual-ru-ro' => ['ru', 'ro'],
            'visual-wa-re' => ['wa', 're'],
            'visual-ki-sa' => ['ki', 'sa'],
            'visual-ha-ho' => ['ha', 'ho'],
            'visual-ko-ni' => ['ko', 'ni'],
        ];

        foreach ($visualGroups as $groupName => $romajiList) {
            $group = new HiraganaGroup();
            $group->setName($groupName);
            $group->setType('visual');
            $group->setDescription('Hiragana visuellement proches, utilisés comme distracteurs difficiles');
            $manager->persist($group);

            foreach ($romajiList as $romaji) {
                /** @var Hiragana $hiragana */
                $hiragana = $this->getReference('hiragana-' . $romaji, Hiragana::class);

                $member = new HiraganaGroupMember();
                $member->setHiragana($hiragana);
                $member->setHiraganaGroup($group);
                $manager->persist($member);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            HiraganaFixtures::class,
        ];
    }
}
