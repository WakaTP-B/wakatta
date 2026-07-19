<?php

namespace App\Repository;

use App\Entity\Hiragana;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hiragana>
 */
class HiraganaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hiragana::class);
    }

    /**
     * Retourne tous les hiragana indexés par romaji, pour lookup facile dans le tableau gojūon.
     *
     * @return array<string, Hiragana>
     */
    public function findAllIndexedByRomaji(): array
    {
        $hiraganas = $this->findAll();
        $indexed = [];

        foreach ($hiraganas as $hiragana) {
            $indexed[$hiragana->getRomaji()] = $hiragana;
        }

        return $indexed;
    }
}
