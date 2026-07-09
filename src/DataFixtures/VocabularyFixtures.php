<?php

namespace App\DataFixtures;

use App\Entity\Difficulty;
use App\Entity\Hiragana;
use App\Entity\Vocabulary;
use App\Entity\VocabularyHiragana;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VocabularyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $vocabularyData = [
            // Facile — 2 hiraganas
            ['hiragana' => 'ねこ', 'romaji' => 'neko', 'french' => 'chat', 'difficulty' => 'facile', 'parts' => ['ne', 'ko']],
            ['hiragana' => 'いぬ', 'romaji' => 'inu', 'french' => 'chien', 'difficulty' => 'facile', 'parts' => ['i', 'nu']],
            ['hiragana' => 'はな', 'romaji' => 'hana', 'french' => 'fleur', 'difficulty' => 'facile', 'parts' => ['ha', 'na']],
            ['hiragana' => 'そら', 'romaji' => 'sora', 'french' => 'ciel', 'difficulty' => 'facile', 'parts' => ['so', 'ra']],
            ['hiragana' => 'つき', 'romaji' => 'tsuki', 'french' => 'lune', 'difficulty' => 'facile', 'parts' => ['tsu', 'ki']],
            ['hiragana' => 'あめ', 'romaji' => 'ame', 'french' => 'pluie', 'difficulty' => 'facile', 'parts' => ['a', 'me']],
            ['hiragana' => 'みみ', 'romaji' => 'mimi', 'french' => 'oreille', 'difficulty' => 'facile', 'parts' => ['mi', 'mi']],
            ['hiragana' => 'くち', 'romaji' => 'kuchi', 'french' => 'bouche', 'difficulty' => 'facile', 'parts' => ['ku', 'chi']],
            ['hiragana' => 'かみ', 'romaji' => 'kami', 'french' => 'cheveux', 'difficulty' => 'facile', 'parts' => ['ka', 'mi']],
            ['hiragana' => 'いし', 'romaji' => 'ishi', 'french' => 'pierre', 'difficulty' => 'facile', 'parts' => ['i', 'shi']],
            ['hiragana' => 'なつ', 'romaji' => 'natsu', 'french' => 'été', 'difficulty' => 'facile', 'parts' => ['na', 'tsu']],

            // Moyen — 2 à 3 hiraganas
            ['hiragana' => 'さかな', 'romaji' => 'sakana', 'french' => 'poisson', 'difficulty' => 'moyen', 'parts' => ['sa', 'ka', 'na']],
            ['hiragana' => 'くるま', 'romaji' => 'kuruma', 'french' => 'voiture', 'difficulty' => 'moyen', 'parts' => ['ku', 'ru', 'ma']],
            ['hiragana' => 'あさ', 'romaji' => 'asa', 'french' => 'matin', 'difficulty' => 'moyen', 'parts' => ['a', 'sa']],
            ['hiragana' => 'よる', 'romaji' => 'yoru', 'french' => 'nuit', 'difficulty' => 'moyen', 'parts' => ['yo', 'ru']],
            ['hiragana' => 'かわ', 'romaji' => 'kawa', 'french' => 'rivière', 'difficulty' => 'moyen', 'parts' => ['ka', 'wa']],
            ['hiragana' => 'はやし', 'romaji' => 'hayashi', 'french' => 'forêt', 'difficulty' => 'moyen', 'parts' => ['ha', 'ya', 'shi']],
            ['hiragana' => 'ひかり', 'romaji' => 'hikari', 'french' => 'lumière', 'difficulty' => 'moyen', 'parts' => ['hi', 'ka', 'ri']],
            ['hiragana' => 'あたま', 'romaji' => 'atama', 'french' => 'tête', 'difficulty' => 'moyen', 'parts' => ['a', 'ta', 'ma']],
            ['hiragana' => 'ちから', 'romaji' => 'chikara', 'french' => 'force', 'difficulty' => 'moyen', 'parts' => ['chi', 'ka', 'ra']],
            ['hiragana' => 'あるく', 'romaji' => 'aruku', 'french' => 'marcher', 'difficulty' => 'moyen', 'parts' => ['a', 'ru', 'ku']],
            ['hiragana' => 'はやい', 'romaji' => 'hayai', 'french' => 'rapide', 'difficulty' => 'moyen', 'parts' => ['ha', 'ya', 'i']],

            // Difficile — 3 hiraganas
            ['hiragana' => 'さくら', 'romaji' => 'sakura', 'french' => 'cerisier', 'difficulty' => 'difficile', 'parts' => ['sa', 'ku', 'ra']],
            ['hiragana' => 'とけい', 'romaji' => 'tokei', 'french' => 'horloge', 'difficulty' => 'difficile', 'parts' => ['to', 'ke', 'i']],
            ['hiragana' => 'さむい', 'romaji' => 'samui', 'french' => 'froid', 'difficulty' => 'difficile', 'parts' => ['sa', 'mu', 'i']],
            ['hiragana' => 'あつい', 'romaji' => 'atsui', 'french' => 'chaud', 'difficulty' => 'difficile', 'parts' => ['a', 'tsu', 'i']],
            ['hiragana' => 'みなみ', 'romaji' => 'minami', 'french' => 'sud', 'difficulty' => 'difficile', 'parts' => ['mi', 'na', 'mi']],
            ['hiragana' => 'むらさき', 'romaji' => 'murasaki', 'french' => 'violet', 'difficulty' => 'difficile', 'parts' => ['mu', 'ra', 'sa', 'ki']],
            ['hiragana' => 'きもち', 'romaji' => 'kimochi', 'french' => 'sentiment', 'difficulty' => 'difficile', 'parts' => ['ki', 'mo', 'chi']],
            ['hiragana' => 'あさひ', 'romaji' => 'asahi', 'french' => 'soleil levant', 'difficulty' => 'difficile', 'parts' => ['a', 'sa', 'hi']],
            ['hiragana' => 'ゆうひ', 'romaji' => 'yuuhi', 'french' => 'soleil couchant', 'difficulty' => 'difficile', 'parts' => ['yu', 'u', 'hi']],
            ['hiragana' => 'からい', 'romaji' => 'karai', 'french' => 'épicé', 'difficulty' => 'difficile', 'parts' => ['ka', 'ra', 'i']],
            ['hiragana' => 'ひろい', 'romaji' => 'hiroi', 'french' => 'large', 'difficulty' => 'difficile', 'parts' => ['hi', 'ro', 'i']],
        ];

        foreach ($vocabularyData as $data) {
            $vocabulary = new Vocabulary();
            $vocabulary->setHiragana($data['hiragana']);
            $vocabulary->setRomaji($data['romaji']);
            $vocabulary->setFrench($data['french']);
            $vocabulary->setCreatedAt(new \DateTimeImmutable());

            /** @var Difficulty $difficulty */
            $difficulty = $this->getReference('difficulty-' . $data['difficulty'], Difficulty::class);
            $vocabulary->setDifficulty($difficulty);

            $manager->persist($vocabulary);
            $this->addReference('vocabulary-' . $data['romaji'], $vocabulary);

            foreach ($data['parts'] as $position => $romaji) {
                $vocabularyHiragana = new VocabularyHiragana();
                $vocabularyHiragana->setVocabulary($vocabulary);

                /** @var Hiragana $hiragana */
                $hiragana = $this->getReference('hiragana-' . $romaji, Hiragana::class);
                $vocabularyHiragana->setHiragana($hiragana);

                $vocabularyHiragana->setPosition($position + 1);
                $manager->persist($vocabularyHiragana);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ReferenceDataFixtures::class,
            HiraganaFixtures::class,
        ];
    }
}
