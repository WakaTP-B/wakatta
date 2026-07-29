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
            ['hiragana' => 'さと', 'romaji' => 'sato', 'french' => 'village natal', 'difficulty' => 'facile', 'parts' => ['sa', 'to']],
            ['hiragana' => 'しま', 'romaji' => 'shima', 'french' => 'île', 'difficulty' => 'facile', 'parts' => ['shi', 'ma']],
            ['hiragana' => 'うみ', 'romaji' => 'umi', 'french' => 'mer', 'difficulty' => 'facile', 'parts' => ['u', 'mi']],
            ['hiragana' => 'そこ', 'romaji' => 'soko', 'french' => 'fond', 'difficulty' => 'facile', 'parts' => ['so', 'ko']],
            ['hiragana' => 'ここ', 'romaji' => 'koko', 'french' => 'ici', 'difficulty' => 'facile', 'parts' => ['ko', 'ko']],
            ['hiragana' => 'いけ', 'romaji' => 'ike', 'french' => 'étang', 'difficulty' => 'facile', 'parts' => ['i', 'ke']],
            ['hiragana' => 'たに', 'romaji' => 'tani', 'french' => 'vallée', 'difficulty' => 'facile', 'parts' => ['ta', 'ni']],
            ['hiragana' => 'まち', 'romaji' => 'machi', 'french' => 'ville', 'difficulty' => 'facile', 'parts' => ['ma', 'chi']],
            ['hiragana' => 'みち', 'romaji' => 'michi', 'french' => 'chemin', 'difficulty' => 'facile', 'parts' => ['mi', 'chi']],
            ['hiragana' => 'いと', 'romaji' => 'ito', 'french' => 'fil', 'difficulty' => 'facile', 'parts' => ['i', 'to']],
            ['hiragana' => 'はた', 'romaji' => 'hata', 'french' => 'champ', 'difficulty' => 'facile', 'parts' => ['ha', 'ta']],
            ['hiragana' => 'さら', 'romaji' => 'sara', 'french' => 'assiette', 'difficulty' => 'facile', 'parts' => ['sa', 'ra']],
            ['hiragana' => 'たま', 'romaji' => 'tama', 'french' => 'bille', 'difficulty' => 'facile', 'parts' => ['ta', 'ma']],
            ['hiragana' => 'すし', 'romaji' => 'sushi', 'french' => 'sushi', 'difficulty' => 'facile', 'parts' => ['su', 'shi']],
            ['hiragana' => 'くつ', 'romaji' => 'kutsu', 'french' => 'chaussures', 'difficulty' => 'facile', 'parts' => ['ku', 'tsu']],
            ['hiragana' => 'さけ', 'romaji' => 'sake', 'french' => 'alcool', 'difficulty' => 'facile', 'parts' => ['sa', 'ke']],
            ['hiragana' => 'きた', 'romaji' => 'kita', 'french' => 'nord', 'difficulty' => 'facile', 'parts' => ['ki', 'ta']],
            ['hiragana' => 'にし', 'romaji' => 'nishi', 'french' => 'ouest', 'difficulty' => 'facile', 'parts' => ['ni', 'shi']],
            ['hiragana' => 'はこ', 'romaji' => 'hako', 'french' => 'boîte', 'difficulty' => 'facile', 'parts' => ['ha', 'ko']],
            ['hiragana' => 'たな', 'romaji' => 'tana', 'french' => 'étagère', 'difficulty' => 'facile', 'parts' => ['ta', 'na']],
            ['hiragana' => 'にわ', 'romaji' => 'niwa', 'french' => 'jardin', 'difficulty' => 'facile', 'parts' => ['ni', 'wa']],
            ['hiragana' => 'うま', 'romaji' => 'uma', 'french' => 'cheval', 'difficulty' => 'facile', 'parts' => ['u', 'ma']],
            ['hiragana' => 'くま', 'romaji' => 'kuma', 'french' => 'ours', 'difficulty' => 'facile', 'parts' => ['ku', 'ma']],
            ['hiragana' => 'さる', 'romaji' => 'saru', 'french' => 'singe', 'difficulty' => 'facile', 'parts' => ['sa', 'ru']],
            ['hiragana' => 'とら', 'romaji' => 'tora', 'french' => 'tigre', 'difficulty' => 'facile', 'parts' => ['to', 'ra']],
            ['hiragana' => 'かに', 'romaji' => 'kani', 'french' => 'crabe', 'difficulty' => 'facile', 'parts' => ['ka', 'ni']],
            ['hiragana' => 'たこ', 'romaji' => 'tako', 'french' => 'poulpe', 'difficulty' => 'facile', 'parts' => ['ta', 'ko']],
            ['hiragana' => 'かめ', 'romaji' => 'kame', 'french' => 'tortue', 'difficulty' => 'facile', 'parts' => ['ka', 'me']],
            ['hiragana' => 'せみ', 'romaji' => 'semi', 'french' => 'cigale', 'difficulty' => 'facile', 'parts' => ['se', 'mi']],
            ['hiragana' => 'はち', 'romaji' => 'hachi', 'french' => 'abeille', 'difficulty' => 'facile', 'parts' => ['ha', 'chi']],
            ['hiragana' => 'あり', 'romaji' => 'ari', 'french' => 'fourmi', 'difficulty' => 'facile', 'parts' => ['a', 'ri']],
            ['hiragana' => 'とも', 'romaji' => 'tomo', 'french' => 'ami', 'difficulty' => 'facile', 'parts' => ['to', 'mo']],
            ['hiragana' => 'つの', 'romaji' => 'tsuno', 'french' => 'corne', 'difficulty' => 'facile', 'parts' => ['tsu', 'no']],
            ['hiragana' => 'くり', 'romaji' => 'kuri', 'french' => 'châtaigne', 'difficulty' => 'facile', 'parts' => ['ku', 'ri']],
            ['hiragana' => 'やすみ', 'romaji' => 'yasumi', 'french' => 'repos', 'difficulty' => 'facile', 'parts' => ['ya', 'su', 'mi']],
            ['hiragana' => 'くうき', 'romaji' => 'kuuki', 'french' => 'air', 'difficulty' => 'facile', 'parts' => ['ku', 'u', 'ki']],
            ['hiragana' => 'おかし', 'romaji' => 'okashi', 'french' => 'friandise', 'difficulty' => 'facile', 'parts' => ['o', 'ka', 'shi']],
            ['hiragana' => 'からて', 'romaji' => 'karate', 'french' => 'karaté', 'difficulty' => 'facile', 'parts' => ['ka', 'ra', 'te']],
            ['hiragana' => 'さいふ', 'romaji' => 'saifu', 'french' => 'portefeuille', 'difficulty' => 'facile', 'parts' => ['sa', 'i', 'fu']],
            ['hiragana' => 'かたち', 'romaji' => 'katachi', 'french' => 'forme', 'difficulty' => 'facile', 'parts' => ['ka', 'ta', 'chi']],

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
            ['hiragana' => 'ふうせん', 'romaji' => 'fuusen', 'french' => 'ballon', 'difficulty' => 'moyen', 'parts' => ['fu', 'u', 'se', 'n']],
            ['hiragana' => 'ゆうやけ', 'romaji' => 'yuuyake', 'french' => 'coucher de soleil', 'difficulty' => 'moyen', 'parts' => ['yu', 'u', 'ya', 'ke']],
            ['hiragana' => 'くつした', 'romaji' => 'kutsushita', 'french' => 'chaussettes', 'difficulty' => 'moyen', 'parts' => ['ku', 'tsu', 'shi', 'ta']],
            ['hiragana' => 'おとうと', 'romaji' => 'ototo', 'french' => 'petit frère', 'difficulty' => 'moyen', 'parts' => ['o', 'to', 'u', 'to']],
            ['hiragana' => 'はさみ', 'romaji' => 'hasami', 'french' => 'ciseaux', 'difficulty' => 'moyen', 'parts' => ['ha', 'sa', 'mi']],
            ['hiragana' => 'あいさつ', 'romaji' => 'aisatsu', 'french' => 'salutation', 'difficulty' => 'moyen', 'parts' => ['a', 'i', 'sa', 'tsu']],
            ['hiragana' => 'せんせい', 'romaji' => 'sensei', 'french' => 'professeur', 'difficulty' => 'moyen', 'parts' => ['se', 'n', 'se', 'i']],
            ['hiragana' => 'きもの', 'romaji' => 'kimono', 'french' => 'kimono', 'difficulty' => 'moyen', 'parts' => ['ki', 'mo', 'no']],
            ['hiragana' => 'おいしい', 'romaji' => 'oishii', 'french' => 'délicieux', 'difficulty' => 'moyen', 'parts' => ['o', 'i', 'shi', 'i']],
            ['hiragana' => 'せかい', 'romaji' => 'sekai', 'french' => 'monde', 'difficulty' => 'moyen', 'parts' => ['se', 'ka', 'i']],
            ['hiragana' => 'くうこう', 'romaji' => 'kuukou', 'french' => 'aéroport', 'difficulty' => 'moyen', 'parts' => ['ku', 'u', 'ko', 'u']],
            ['hiragana' => 'とかい', 'romaji' => 'tokai', 'french' => 'ville (urbaine)', 'difficulty' => 'moyen', 'parts' => ['to', 'ka', 'i']],
            ['hiragana' => 'けしき', 'romaji' => 'keshiki', 'french' => 'paysage', 'difficulty' => 'moyen', 'parts' => ['ke', 'shi', 'ki']],

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
            ['hiragana' => 'おとうさん', 'romaji' => 'otousan', 'french' => 'père', 'difficulty' => 'difficile', 'parts' => ['o', 'to', 'u', 'sa', 'n']],
            ['hiragana' => 'おかあさん', 'romaji' => 'okaasan', 'french' => 'mère', 'difficulty' => 'difficile', 'parts' => ['o', 'ka', 'a', 'sa', 'n']],
            ['hiragana' => 'なつやすみ', 'romaji' => 'natsuyasumi', 'french' => 'vacances d\'été', 'difficulty' => 'difficile', 'parts' => ['na', 'tsu', 'ya', 'su', 'mi']],
            ['hiragana' => 'ふゆやすみ', 'romaji' => 'fuyuyasumi', 'french' => 'vacances d\'hiver', 'difficulty' => 'difficile', 'parts' => ['fu', 'yu', 'ya', 'su', 'mi']],
            ['hiragana' => 'はるやすみ', 'romaji' => 'haruyasumi', 'french' => 'vacances de printemps', 'difficulty' => 'difficile', 'parts' => ['ha', 'ru', 'ya', 'su', 'mi']],
            ['hiragana' => 'くうそう', 'romaji' => 'kuusou', 'french' => 'imagination', 'difficulty' => 'difficile', 'parts' => ['ku', 'u', 'so', 'u']],
            ['hiragana' => 'たいせつ', 'romaji' => 'taisetsu', 'french' => 'important', 'difficulty' => 'difficile', 'parts' => ['ta', 'i', 'se', 'tsu']],
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
