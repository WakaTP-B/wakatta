<?php

namespace App\Entity;

use App\Repository\VocabularyHiraganaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VocabularyHiraganaRepository::class)]
class VocabularyHiragana
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vocabularyHiraganas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vocabulary $vocabulary = null;

    #[ORM\Column]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVocabulary(): ?Vocabulary
    {
        return $this->vocabulary;
    }

    public function setVocabulary(?Vocabulary $vocabulary): static
    {
        $this->vocabulary = $vocabulary;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
