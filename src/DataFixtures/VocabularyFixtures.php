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
            // Facile 2 à 3 hiraganas
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
            ['hiragana' => 'へや', 'romaji' => 'heya', 'french' => 'chambre', 'difficulty' => 'facile', 'parts' => ['he', 'ya']],
            ['hiragana' => 'ほね', 'romaji' => 'hone', 'french' => 'os', 'difficulty' => 'facile', 'parts' => ['ho', 'ne']],
            ['hiragana' => 'こえ', 'romaji' => 'koe', 'french' => 'voix', 'difficulty' => 'facile', 'parts' => ['ko', 'e']],
            ['hiragana' => 'おと', 'romaji' => 'oto', 'french' => 'son', 'difficulty' => 'facile', 'parts' => ['o', 'to']],
            ['hiragana' => 'ゆめ', 'romaji' => 'yume', 'french' => 'rêve', 'difficulty' => 'facile', 'parts' => ['yu', 'me']],
            ['hiragana' => 'つえ', 'romaji' => 'tsue', 'french' => 'canne', 'difficulty' => 'facile', 'parts' => ['tsu', 'e']],
            ['hiragana' => 'おに', 'romaji' => 'oni', 'french' => 'ogre', 'difficulty' => 'facile', 'parts' => ['o', 'ni']],
            ['hiragana' => 'ひと', 'romaji' => 'hito', 'french' => 'personne', 'difficulty' => 'facile', 'parts' => ['hi', 'to']],
            ['hiragana' => 'ふね', 'romaji' => 'fune', 'french' => 'bateau', 'difficulty' => 'facile', 'parts' => ['fu', 'ne']],
            ['hiragana' => 'てら', 'romaji' => 'tera', 'french' => 'temple', 'difficulty' => 'facile', 'parts' => ['te', 'ra']],
            ['hiragana' => 'もの', 'romaji' => 'mono', 'french' => 'chose', 'difficulty' => 'facile', 'parts' => ['mo', 'no']],
            ['hiragana' => 'あに', 'romaji' => 'ani', 'french' => 'grand frère', 'difficulty' => 'facile', 'parts' => ['a', 'ni']],
            ['hiragana' => 'あね', 'romaji' => 'ane', 'french' => 'grande sœur', 'difficulty' => 'facile', 'parts' => ['a', 'ne']],
            ['hiragana' => 'いま', 'romaji' => 'ima', 'french' => 'maintenant', 'difficulty' => 'facile', 'parts' => ['i', 'ma']],
            ['hiragana' => 'ほし', 'romaji' => 'hoshi', 'french' => 'étoile', 'difficulty' => 'facile', 'parts' => ['ho', 'shi']],
            ['hiragana' => 'ふく', 'romaji' => 'fuku', 'french' => 'vêtement', 'difficulty' => 'facile', 'parts' => ['fu', 'ku']],
            ['hiragana' => 'なか', 'romaji' => 'naka', 'french' => 'intérieur', 'difficulty' => 'facile', 'parts' => ['na', 'ka']],
            ['hiragana' => 'よこ', 'romaji' => 'yoko', 'french' => 'côté', 'difficulty' => 'facile', 'parts' => ['yo', 'ko']],
            ['hiragana' => 'まえ', 'romaji' => 'mae', 'french' => 'devant', 'difficulty' => 'facile', 'parts' => ['ma', 'e']],
            ['hiragana' => 'した', 'romaji' => 'shita', 'french' => 'dessous', 'difficulty' => 'facile', 'parts' => ['shi', 'ta']],
            ['hiragana' => 'うえ', 'romaji' => 'ue', 'french' => 'dessus', 'difficulty' => 'facile', 'parts' => ['u', 'e']],
            ['hiragana' => 'あせ', 'romaji' => 'ase', 'french' => 'sueur', 'difficulty' => 'facile', 'parts' => ['a', 'se']],
            ['hiragana' => 'ねつ', 'romaji' => 'netsu', 'french' => 'fièvre', 'difficulty' => 'facile', 'parts' => ['ne', 'tsu']],
            ['hiragana' => 'しお', 'romaji' => 'shio', 'french' => 'sel', 'difficulty' => 'facile', 'parts' => ['shi', 'o']],
            ['hiragana' => 'にく', 'romaji' => 'niku', 'french' => 'viande', 'difficulty' => 'facile', 'parts' => ['ni', 'ku']],
            ['hiragana' => 'みそ', 'romaji' => 'miso', 'french' => 'miso', 'difficulty' => 'facile', 'parts' => ['mi', 'so']],
            ['hiragana' => 'こな', 'romaji' => 'kona', 'french' => 'poudre', 'difficulty' => 'facile', 'parts' => ['ko', 'na']],
            ['hiragana' => 'ひふ', 'romaji' => 'hifu', 'french' => 'peau', 'difficulty' => 'facile', 'parts' => ['hi', 'fu']],
            ['hiragana' => 'さとう', 'romaji' => 'satou', 'french' => 'sucre', 'difficulty' => 'facile', 'parts' => ['sa', 'to', 'u']],
            ['hiragana' => 'やさい', 'romaji' => 'yasai', 'french' => 'légume', 'difficulty' => 'facile', 'parts' => ['ya', 'sa', 'i']],
            ['hiragana' => 'いのち', 'romaji' => 'inochi', 'french' => 'vie', 'difficulty' => 'facile', 'parts' => ['i', 'no', 'chi']],
            ['hiragana' => 'ちしき', 'romaji' => 'chishiki', 'french' => 'connaissance', 'difficulty' => 'facile', 'parts' => ['chi', 'shi', 'ki']],
            ['hiragana' => 'うしろ', 'romaji' => 'ushiro', 'french' => 'derrière', 'difficulty' => 'facile', 'parts' => ['u', 'shi', 'ro']],
            ['hiragana' => 'せなか', 'romaji' => 'senaka', 'french' => 'dos', 'difficulty' => 'facile', 'parts' => ['se', 'na', 'ka']],
            ['hiragana' => 'こおり', 'romaji' => 'koori', 'french' => 'glace', 'difficulty' => 'facile', 'parts' => ['ko', 'o', 'ri']],
            ['hiragana' => 'ほのお', 'romaji' => 'honoo', 'french' => 'flamme', 'difficulty' => 'facile', 'parts' => ['ho', 'no', 'o']],

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
            ['hiragana' => 'おとうと', 'romaji' => 'otouto', 'french' => 'petit frère', 'difficulty' => 'moyen', 'parts' => ['o', 'to', 'u', 'to']],
            ['hiragana' => 'はさみ', 'romaji' => 'hasami', 'french' => 'ciseaux', 'difficulty' => 'moyen', 'parts' => ['ha', 'sa', 'mi']],
            ['hiragana' => 'あいさつ', 'romaji' => 'aisatsu', 'french' => 'salutation', 'difficulty' => 'moyen', 'parts' => ['a', 'i', 'sa', 'tsu']],
            ['hiragana' => 'せんせい', 'romaji' => 'sensei', 'french' => 'professeur', 'difficulty' => 'moyen', 'parts' => ['se', 'n', 'se', 'i']],
            ['hiragana' => 'きもの', 'romaji' => 'kimono', 'french' => 'kimono', 'difficulty' => 'moyen', 'parts' => ['ki', 'mo', 'no']],
            ['hiragana' => 'おいしい', 'romaji' => 'oishii', 'french' => 'délicieux', 'difficulty' => 'moyen', 'parts' => ['o', 'i', 'shi', 'i']],
            ['hiragana' => 'せかい', 'romaji' => 'sekai', 'french' => 'monde', 'difficulty' => 'moyen', 'parts' => ['se', 'ka', 'i']],
            ['hiragana' => 'くうこう', 'romaji' => 'kuukou', 'french' => 'aéroport', 'difficulty' => 'moyen', 'parts' => ['ku', 'u', 'ko', 'u']],
            ['hiragana' => 'とかい', 'romaji' => 'tokai', 'french' => 'ville (urbaine)', 'difficulty' => 'moyen', 'parts' => ['to', 'ka', 'i']],
            ['hiragana' => 'けしき', 'romaji' => 'keshiki', 'french' => 'paysage', 'difficulty' => 'moyen', 'parts' => ['ke', 'shi', 'ki']],
            ['hiragana' => 'こころ', 'romaji' => 'kokoro', 'french' => 'cœur', 'difficulty' => 'moyen', 'parts' => ['ko', 'ko', 'ro']],
            ['hiragana' => 'ことり', 'romaji' => 'kotori', 'french' => 'petit oiseau', 'difficulty' => 'moyen', 'parts' => ['ko', 'to', 'ri']],
            ['hiragana' => 'おとな', 'romaji' => 'otona', 'french' => 'adulte', 'difficulty' => 'moyen', 'parts' => ['o', 'to', 'na']],
            ['hiragana' => 'こたえ', 'romaji' => 'kotae', 'french' => 'réponse', 'difficulty' => 'moyen', 'parts' => ['ko', 'ta', 'e']],
            ['hiragana' => 'まくら', 'romaji' => 'makura', 'french' => 'oreiller', 'difficulty' => 'moyen', 'parts' => ['ma', 'ku', 'ra']],
            ['hiragana' => 'おなか', 'romaji' => 'onaka', 'french' => 'ventre', 'difficulty' => 'moyen', 'parts' => ['o', 'na', 'ka']],
            ['hiragana' => 'てあし', 'romaji' => 'teashi', 'french' => 'mains et pieds', 'difficulty' => 'moyen', 'parts' => ['te', 'a', 'shi']],
            ['hiragana' => 'たより', 'romaji' => 'tayori', 'french' => 'nouvelles', 'difficulty' => 'moyen', 'parts' => ['ta', 'yo', 'ri']],
            ['hiragana' => 'なかま', 'romaji' => 'nakama', 'french' => 'compagnon', 'difficulty' => 'moyen', 'parts' => ['na', 'ka', 'ma']],
            ['hiragana' => 'いなか', 'romaji' => 'inaka', 'french' => 'campagne', 'difficulty' => 'moyen', 'parts' => ['i', 'na', 'ka']],
            ['hiragana' => 'てんき', 'romaji' => 'tenki', 'french' => 'météo', 'difficulty' => 'moyen', 'parts' => ['te', 'n', 'ki']],
            ['hiragana' => 'てんし', 'romaji' => 'tenshi', 'french' => 'ange', 'difficulty' => 'moyen', 'parts' => ['te', 'n', 'shi']],
            ['hiragana' => 'おかね', 'romaji' => 'okane', 'french' => 'argent', 'difficulty' => 'moyen', 'parts' => ['o', 'ka', 'ne']],
            ['hiragana' => 'せいと', 'romaji' => 'seito', 'french' => 'élève', 'difficulty' => 'moyen', 'parts' => ['se', 'i', 'to']],
            ['hiragana' => 'かいわ', 'romaji' => 'kaiwa', 'french' => 'conversation', 'difficulty' => 'moyen', 'parts' => ['ka', 'i', 'wa']],
            ['hiragana' => 'いけん', 'romaji' => 'iken', 'french' => 'opinion', 'difficulty' => 'moyen', 'parts' => ['i', 'ke', 'n']],
            ['hiragana' => 'しあい', 'romaji' => 'shiai', 'french' => 'match', 'difficulty' => 'moyen', 'parts' => ['shi', 'a', 'i']],
            ['hiragana' => 'ゆうき', 'romaji' => 'yuuki', 'french' => 'courage', 'difficulty' => 'moyen', 'parts' => ['yu', 'u', 'ki']],
            ['hiragana' => 'ひこうき', 'romaji' => 'hikouki', 'french' => 'avion', 'difficulty' => 'moyen', 'parts' => ['hi', 'ko', 'u', 'ki']],
            ['hiragana' => 'おんせん', 'romaji' => 'onsen', 'french' => 'source chaude', 'difficulty' => 'moyen', 'parts' => ['o', 'n', 'se', 'n']],
            ['hiragana' => 'せんそう', 'romaji' => 'sensou', 'french' => 'guerre', 'difficulty' => 'moyen', 'parts' => ['se', 'n', 'so', 'u']],
            ['hiragana' => 'しつもん', 'romaji' => 'shitsumon', 'french' => 'question', 'difficulty' => 'moyen', 'parts' => ['shi', 'tsu', 'mo', 'n']],
            ['hiragana' => 'せいかつ', 'romaji' => 'seikatsu', 'french' => 'vie quotidienne', 'difficulty' => 'moyen', 'parts' => ['se', 'i', 'ka', 'tsu']],
            ['hiragana' => 'ほんとう', 'romaji' => 'hontou', 'french' => 'vérité', 'difficulty' => 'moyen', 'parts' => ['ho', 'n', 'to', 'u']],
            ['hiragana' => 'あんしん', 'romaji' => 'anshin', 'french' => 'tranquillité', 'difficulty' => 'moyen', 'parts' => ['a', 'n', 'shi', 'n']],
            ['hiragana' => 'しんせつ', 'romaji' => 'shinsetsu', 'french' => 'gentil', 'difficulty' => 'moyen', 'parts' => ['shi', 'n', 'se', 'tsu']],
            ['hiragana' => 'けいかく', 'romaji' => 'keikaku', 'french' => 'plan', 'difficulty' => 'moyen', 'parts' => ['ke', 'i', 'ka', 'ku']],
            ['hiragana' => 'ちかてつ', 'romaji' => 'chikatetsu', 'french' => 'métro', 'difficulty' => 'moyen', 'parts' => ['chi', 'ka', 'te', 'tsu']],
            ['hiragana' => 'あんない', 'romaji' => 'annai', 'french' => 'guide', 'difficulty' => 'moyen', 'parts' => ['a', 'n', 'na', 'i']],

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
            ['hiragana' => 'たいよう', 'romaji' => 'taiyou', 'french' => 'soleil', 'difficulty' => 'difficile', 'parts' => ['ta', 'i', 'yo', 'u']],
            ['hiragana' => 'てあらい', 'romaji' => 'tearai', 'french' => 'toilettes', 'difficulty' => 'difficile', 'parts' => ['te', 'a', 'ra', 'i']],
            ['hiragana' => 'わかもの', 'romaji' => 'wakamono', 'french' => 'jeune (personne)', 'difficulty' => 'difficile', 'parts' => ['wa', 'ka', 'mo', 'no']],
            ['hiragana' => 'てならい', 'romaji' => 'tenarai', 'french' => 'apprentissage', 'difficulty' => 'difficile', 'parts' => ['te', 'na', 'ra', 'i']],
            ['hiragana' => 'ねむたい', 'romaji' => 'nemutai', 'french' => 'somnolent', 'difficulty' => 'difficile', 'parts' => ['ne', 'mu', 'ta', 'i']],
            ['hiragana' => 'やさしい', 'romaji' => 'yasashii', 'french' => 'doux', 'difficulty' => 'difficile', 'parts' => ['ya', 'sa', 'shi', 'i']],
            ['hiragana' => 'かなしい', 'romaji' => 'kanashii', 'french' => 'triste', 'difficulty' => 'difficile', 'parts' => ['ka', 'na', 'shi', 'i']],
            ['hiragana' => 'あかるい', 'romaji' => 'akarui', 'french' => 'lumineux', 'difficulty' => 'difficile', 'parts' => ['a', 'ka', 'ru', 'i']],
            ['hiragana' => 'つめたい', 'romaji' => 'tsumetai', 'french' => 'glacé', 'difficulty' => 'difficile', 'parts' => ['tsu', 'me', 'ta', 'i']],
            ['hiragana' => 'ゆうめい', 'romaji' => 'yuumei', 'french' => 'célèbre', 'difficulty' => 'difficile', 'parts' => ['yu', 'u', 'me', 'i']],
            ['hiragana' => 'しんせん', 'romaji' => 'shinsen', 'french' => 'frais', 'difficulty' => 'difficile', 'parts' => ['shi', 'n', 'se', 'n']],
            ['hiragana' => 'しつれい', 'romaji' => 'shitsurei', 'french' => 'impoli', 'difficulty' => 'difficile', 'parts' => ['shi', 'tsu', 're', 'i']],
            ['hiragana' => 'せいかく', 'romaji' => 'seikaku', 'french' => 'caractère', 'difficulty' => 'difficile', 'parts' => ['se', 'i', 'ka', 'ku']],
            ['hiragana' => 'ほうりつ', 'romaji' => 'houritsu', 'french' => 'loi', 'difficulty' => 'difficile', 'parts' => ['ho', 'u', 'ri', 'tsu']],
            ['hiragana' => 'せいこう', 'romaji' => 'seikou', 'french' => 'succès', 'difficulty' => 'difficile', 'parts' => ['se', 'i', 'ko', 'u']],
            ['hiragana' => 'けいけん', 'romaji' => 'keiken', 'french' => 'expérience', 'difficulty' => 'difficile', 'parts' => ['ke', 'i', 'ke', 'n']],
            ['hiragana' => 'こうこう', 'romaji' => 'koukou', 'french' => 'lycée', 'difficulty' => 'difficile', 'parts' => ['ko', 'u', 'ko', 'u']],
            ['hiragana' => 'せんもん', 'romaji' => 'senmon', 'french' => 'spécialité', 'difficulty' => 'difficile', 'parts' => ['se', 'n', 'mo', 'n']],
            ['hiragana' => 'たいふう', 'romaji' => 'taifuu', 'french' => 'typhon', 'difficulty' => 'difficile', 'parts' => ['ta', 'i', 'fu', 'u']],
            ['hiragana' => 'おうさま', 'romaji' => 'ousama', 'french' => 'roi', 'difficulty' => 'difficile', 'parts' => ['o', 'u', 'sa', 'ma']],
            ['hiragana' => 'ようかい', 'romaji' => 'youkai', 'french' => 'yōkai', 'difficulty' => 'difficile', 'parts' => ['yo', 'u', 'ka', 'i']],
            ['hiragana' => 'しあわせ', 'romaji' => 'shiawase', 'french' => 'bonheur', 'difficulty' => 'difficile', 'parts' => ['shi', 'a', 'wa', 'se']],
            ['hiragana' => 'あたらしい', 'romaji' => 'atarashii', 'french' => 'nouveau', 'difficulty' => 'difficile', 'parts' => ['a', 'ta', 'ra', 'shi', 'i']],
            ['hiragana' => 'おもしろい', 'romaji' => 'omoshiroi', 'french' => 'intéressant', 'difficulty' => 'difficile', 'parts' => ['o', 'mo', 'shi', 'ro', 'i']],
            ['hiragana' => 'うつくしい', 'romaji' => 'utsukushii', 'french' => 'beau', 'difficulty' => 'difficile', 'parts' => ['u', 'tsu', 'ku', 'shi', 'i']],
            ['hiragana' => 'なつかしい', 'romaji' => 'natsukashii', 'french' => 'nostalgique', 'difficulty' => 'difficile', 'parts' => ['na', 'tsu', 'ka', 'shi', 'i']],
            ['hiragana' => 'あたたかい', 'romaji' => 'atatakai', 'french' => 'tiède', 'difficulty' => 'difficile', 'parts' => ['a', 'ta', 'ta', 'ka', 'i']],
            ['hiragana' => 'おもてなし', 'romaji' => 'omotenashi', 'french' => 'hospitalité', 'difficulty' => 'difficile', 'parts' => ['o', 'mo', 'te', 'na', 'shi']],
            ['hiragana' => 'なつまつり', 'romaji' => 'natsumatsuri', 'french' => 'fête d\'été', 'difficulty' => 'difficile', 'parts' => ['na', 'tsu', 'ma', 'tsu', 'ri']],
            ['hiragana' => 'ひるやすみ', 'romaji' => 'hiruyasumi', 'french' => 'pause déjeuner', 'difficulty' => 'difficile', 'parts' => ['hi', 'ru', 'ya', 'su', 'mi']],
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
