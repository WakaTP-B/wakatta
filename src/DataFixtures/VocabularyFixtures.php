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
            ['hiragana' => 'とり', 'romaji' => 'tori', 'french' => 'oiseau', 'difficulty' => 'facile', 'parts' => ['to', 'ri']],
            ['hiragana' => 'やま', 'romaji' => 'yama', 'french' => 'montagne', 'difficulty' => 'facile', 'parts' => ['ya', 'ma']],
            ['hiragana' => 'かさ', 'romaji' => 'kasa', 'french' => 'parapluie', 'difficulty' => 'facile', 'parts' => ['ka', 'sa']],
            ['hiragana' => 'くも', 'romaji' => 'kumo', 'french' => 'nuage', 'difficulty' => 'facile', 'parts' => ['ku', 'mo']],
            ['hiragana' => 'ゆき', 'romaji' => 'yuki', 'french' => 'neige', 'difficulty' => 'facile', 'parts' => ['yu', 'ki']],
            ['hiragana' => 'なみ', 'romaji' => 'nami', 'french' => 'vague', 'difficulty' => 'facile', 'parts' => ['na', 'mi']],
            ['hiragana' => 'こめ', 'romaji' => 'kome', 'french' => 'riz', 'difficulty' => 'facile', 'parts' => ['ko', 'me']],
            ['hiragana' => 'たけ', 'romaji' => 'take', 'french' => 'bambou', 'difficulty' => 'facile', 'parts' => ['ta', 'ke']],
            ['hiragana' => 'むし', 'romaji' => 'mushi', 'french' => 'insecte', 'difficulty' => 'facile', 'parts' => ['mu', 'shi']],
            ['hiragana' => 'はし', 'romaji' => 'hashi', 'french' => 'pont', 'difficulty' => 'facile', 'parts' => ['ha', 'shi']],
            ['hiragana' => 'とし', 'romaji' => 'toshi', 'french' => 'année', 'difficulty' => 'facile', 'parts' => ['to', 'shi']],
            ['hiragana' => 'うた', 'romaji' => 'uta', 'french' => 'chanson', 'difficulty' => 'facile', 'parts' => ['u', 'ta']],
            ['hiragana' => 'いろ', 'romaji' => 'iro', 'french' => 'couleur', 'difficulty' => 'facile', 'parts' => ['i', 'ro']],
            ['hiragana' => 'かお', 'romaji' => 'kao', 'french' => 'visage', 'difficulty' => 'facile', 'parts' => ['ka', 'o']],
            ['hiragana' => 'あし', 'romaji' => 'ashi', 'french' => 'pied', 'difficulty' => 'facile', 'parts' => ['a', 'shi']],

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
            ['hiragana' => 'のむ', 'romaji' => 'nomu', 'french' => 'boire', 'difficulty' => 'moyen', 'parts' => ['no', 'mu']],
            ['hiragana' => 'みせ', 'romaji' => 'mise', 'french' => 'magasin', 'difficulty' => 'moyen', 'parts' => ['mi', 'se']],
            ['hiragana' => 'ふゆ', 'romaji' => 'fuyu', 'french' => 'hiver', 'difficulty' => 'moyen', 'parts' => ['fu', 'yu']],
            ['hiragana' => 'はる', 'romaji' => 'haru', 'french' => 'printemps', 'difficulty' => 'moyen', 'parts' => ['ha', 'ru']],
            ['hiragana' => 'あき', 'romaji' => 'aki', 'french' => 'automne', 'difficulty' => 'moyen', 'parts' => ['a', 'ki']],
            ['hiragana' => 'つち', 'romaji' => 'tsuchi', 'french' => 'terre', 'difficulty' => 'moyen', 'parts' => ['tsu', 'chi']],
            ['hiragana' => 'そと', 'romaji' => 'soto', 'french' => 'extérieur', 'difficulty' => 'moyen', 'parts' => ['so', 'to']],
            ['hiragana' => 'うち', 'romaji' => 'uchi', 'french' => 'maison', 'difficulty' => 'moyen', 'parts' => ['u', 'chi']],
            ['hiragana' => 'はしる', 'romaji' => 'hashiru', 'french' => 'courir', 'difficulty' => 'moyen', 'parts' => ['ha', 'shi', 'ru']],
            ['hiragana' => 'くすり', 'romaji' => 'kusuri', 'french' => 'médicament', 'difficulty' => 'moyen', 'parts' => ['ku', 'su', 'ri']],
            ['hiragana' => 'きせつ', 'romaji' => 'kisetsu', 'french' => 'saison', 'difficulty' => 'moyen', 'parts' => ['ki', 'se', 'tsu']],
            ['hiragana' => 'あなた', 'romaji' => 'anata', 'french' => 'toi', 'difficulty' => 'moyen', 'parts' => ['a', 'na', 'ta']],

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
            ['hiragana' => 'わすれる', 'romaji' => 'wasureru', 'french' => 'oublier', 'difficulty' => 'difficile', 'parts' => ['wa', 'su', 're', 'ru']],
            ['hiragana' => 'きのう', 'romaji' => 'kinou', 'french' => 'hier', 'difficulty' => 'difficile', 'parts' => ['ki', 'no', 'u']],
            ['hiragana' => 'あした', 'romaji' => 'ashita', 'french' => 'demain', 'difficulty' => 'difficile', 'parts' => ['a', 'shi', 'ta']],
            ['hiragana' => 'まいにち', 'romaji' => 'mainichi', 'french' => 'tous les jours', 'difficulty' => 'difficile', 'parts' => ['ma', 'i', 'ni', 'chi']],
            ['hiragana' => 'たのしい', 'romaji' => 'tanoshii', 'french' => 'amusant', 'difficulty' => 'difficile', 'parts' => ['ta', 'no', 'shi', 'i']],
            ['hiragana' => 'うれしい', 'romaji' => 'ureshii', 'french' => 'content', 'difficulty' => 'difficile', 'parts' => ['u', 're', 'shi', 'i']],
            ['hiragana' => 'とおい', 'romaji' => 'tooi', 'french' => 'loin', 'difficulty' => 'difficile', 'parts' => ['to', 'o', 'i']],
            ['hiragana' => 'ちいさい', 'romaji' => 'chiisai', 'french' => 'petit', 'difficulty' => 'difficile', 'parts' => ['chi', 'i', 'sa', 'i']],
            ['hiragana' => 'おおきい', 'romaji' => 'ookii', 'french' => 'grand', 'difficulty' => 'difficile', 'parts' => ['o', 'o', 'ki', 'i']],
            ['hiragana' => 'すいか', 'romaji' => 'suika', 'french' => 'pastèque', 'difficulty' => 'difficile', 'parts' => ['su', 'i', 'ka']],
            ['hiragana' => 'さしみ', 'romaji' => 'sashimi', 'french' => 'sashimi', 'difficulty' => 'difficile', 'parts' => ['sa', 'shi', 'mi']],
            ['hiragana' => 'みなと', 'romaji' => 'minato', 'french' => 'port', 'difficulty' => 'difficile', 'parts' => ['mi', 'na', 'to']],
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
