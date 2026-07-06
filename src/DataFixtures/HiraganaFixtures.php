<?php

namespace App\DataFixtures;

use App\Entity\Hiragana;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HiraganaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hiraganaData = [

            // Voyelles
            ['character' => 'あ', 'romaji' => 'a', 'position' => 1, 'strokeCount' => 3],
            ['character' => 'い', 'romaji' => 'i', 'position' => 2, 'strokeCount' => 2],
            ['character' => 'う', 'romaji' => 'u', 'position' => 3, 'strokeCount' => 2],
            ['character' => 'え', 'romaji' => 'e', 'position' => 4, 'strokeCount' => 2],
            ['character' => 'お', 'romaji' => 'o', 'position' => 5, 'strokeCount' => 3],

            // Group K
            ['character' => 'か', 'romaji' => 'ka', 'position' => 6, 'strokeCount' => 3],
            ['character' => 'き', 'romaji' => 'ki', 'position' => 7, 'strokeCount' => 4],
            ['character' => 'く', 'romaji' => 'ku', 'position' => 8, 'strokeCount' => 1],
            ['character' => 'け', 'romaji' => 'ke', 'position' => 9, 'strokeCount' => 3],
            ['character' => 'こ', 'romaji' => 'ko', 'position' => 10, 'strokeCount' => 2],

            // Group S
            ['character' => 'さ', 'romaji' => 'sa', 'position' => 11, 'strokeCount' => 3],
            ['character' => 'し', 'romaji' => 'shi', 'position' => 12, 'strokeCount' => 1],
            ['character' => 'す', 'romaji' => 'su', 'position' => 13, 'strokeCount' => 2],
            ['character' => 'せ', 'romaji' => 'se', 'position' => 14, 'strokeCount' => 3],
            ['character' => 'そ', 'romaji' => 'so', 'position' => 15, 'strokeCount' => 1],

            // Group T
            ['character' => 'た', 'romaji' => 'ta', 'position' => 16, 'strokeCount' => 4],
            ['character' => 'ち', 'romaji' => 'chi', 'position' => 17, 'strokeCount' => 2],
            ['character' => 'つ', 'romaji' => 'tsu', 'position' => 18, 'strokeCount' => 1],
            ['character' => 'て', 'romaji' => 'te', 'position' => 19, 'strokeCount' => 1],
            ['character' => 'と', 'romaji' => 'to', 'position' => 20, 'strokeCount' => 2],

            // Group N
            ['character' => 'な', 'romaji' => 'na', 'position' => 21, 'strokeCount' => 4],
            ['character' => 'に', 'romaji' => 'ni', 'position' => 22, 'strokeCount' => 3],
            ['character' => 'ぬ', 'romaji' => 'nu', 'position' => 23, 'strokeCount' => 2],
            ['character' => 'ね', 'romaji' => 'ne', 'position' => 24, 'strokeCount' => 2],
            ['character' => 'の', 'romaji' => 'no', 'position' => 25, 'strokeCount' => 1],

            // Group H
            ['character' => 'は', 'romaji' => 'ha', 'position' => 26, 'strokeCount' => 3],
            ['character' => 'ひ', 'romaji' => 'hi', 'position' => 27, 'strokeCount' => 1],
            ['character' => 'ふ', 'romaji' => 'fu', 'position' => 28, 'strokeCount' => 4],
            ['character' => 'へ', 'romaji' => 'he', 'position' => 29, 'strokeCount' => 1],
            ['character' => 'ほ', 'romaji' => 'ho', 'position' => 30, 'strokeCount' => 4],

            // Group M
            ['character' => 'ま', 'romaji' => 'ma', 'position' => 31, 'strokeCount' => 3],
            ['character' => 'み', 'romaji' => 'mi', 'position' => 32, 'strokeCount' => 2],
            ['character' => 'む', 'romaji' => 'mu', 'position' => 33, 'strokeCount' => 3],
            ['character' => 'め', 'romaji' => 'me', 'position' => 34, 'strokeCount' => 2],
            ['character' => 'も', 'romaji' => 'mo', 'position' => 35, 'strokeCount' => 3],

            // Group Y
            ['character' => 'や', 'romaji' => 'ya', 'position' => 36, 'strokeCount' => 3],
            ['character' => 'ゆ', 'romaji' => 'yu', 'position' => 37, 'strokeCount' => 2],
            ['character' => 'よ', 'romaji' => 'yo', 'position' => 38, 'strokeCount' => 2],

            // Group R
            ['character' => 'ら', 'romaji' => 'ra', 'position' => 39, 'strokeCount' => 2],
            ['character' => 'り', 'romaji' => 'ri', 'position' => 40, 'strokeCount' => 2],
            ['character' => 'る', 'romaji' => 'ru', 'position' => 41, 'strokeCount' => 1],
            ['character' => 'れ', 'romaji' => 're', 'position' => 42, 'strokeCount' => 2],
            ['character' => 'ろ', 'romaji' => 'ro', 'position' => 43, 'strokeCount' => 1],

            // Group W
            ['character' => 'わ', 'romaji' => 'wa', 'position' => 44, 'strokeCount' => 2],
            ['character' => 'を', 'romaji' => 'wo', 'position' => 45, 'strokeCount' => 3],

            // N final
            ['character' => 'ん', 'romaji' => 'n', 'position' => 46, 'strokeCount' => 1],
        ];

        $hiraganaEntities = [];
        foreach ($hiraganaData as $data) {
            $hiragana = new Hiragana();
            $hiragana->setCharacter($data['character']);
            $hiragana->setRomaji($data['romaji']);
            $hiragana->setPosition($data['position']);
            $hiragana->setStrokeCount($data['strokeCount']);
            $manager->persist($hiragana);
            $this->addReference('hiragana-' . $data['romaji'], $hiragana);
            $hiraganaEntities[$data['romaji']] = $hiragana;
        }

        $manager->flush();
    }
}
