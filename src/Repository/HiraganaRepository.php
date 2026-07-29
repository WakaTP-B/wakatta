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


    /**
     * Récupère des hiragana par une liste d'ids, en respectant l'ordre donné.
     * Utilisé pour reconstruire les choix figés dans l'URL (anti-triche au F5).
     *
     * @param int[] $ids
     * @return Hiragana[]
     */
    public function findByIdsPreservingOrder(array $ids): array
    {
        $hiraganas = $this->createQueryBuilder('h')
            ->andWhere('h.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        $indexed = [];
        foreach ($hiraganas as $hiragana) {
            $indexed[$hiragana->getId()] = $hiragana;
        }

        // On reconstruit dans l'ordre exact de $ids (la requête SQL ne le garantit pas)
        return array_map(fn(int $id) => $indexed[$id], $ids);
    }


    /**
     * Récupère des hiragana aléatoires, en excluant une liste d'ids donnée.
     * Utilisé pour les distracteurs "standards" (niveaux Facile/Moyen).
     *
     * @param int[] $excludeIds
     * @return Hiragana[]
     */
    public function findRandomExcluding(array $excludeIds, int $count): array
    {
        $hiraganas = $this->createQueryBuilder('h')
            ->andWhere('h.id NOT IN (:excludeIds)')
            ->setParameter('excludeIds', $excludeIds)
            ->getQuery()
            ->getResult();

        shuffle($hiraganas);

        return array_slice($hiraganas, 0, $count);
    }
    
}
