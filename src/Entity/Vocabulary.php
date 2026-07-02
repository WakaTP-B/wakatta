<?php

namespace App\Entity;

use App\Repository\VocabularyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VocabularyRepository::class)]
class Vocabulary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Difficulty $difficulty = null;

    #[ORM\Column(length: 50)]
    private ?string $hiragana = null;

    #[ORM\Column(length: 50)]
    private ?string $romaji = null;

    #[ORM\Column(length: 100)]
    private ?string $french = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, VocabularyHiragana>
     */
    #[ORM\OneToMany(targetEntity: VocabularyHiragana::class, mappedBy: 'vocabulary', orphanRemoval: true)]
    private Collection $vocabularyHiraganas;

    public function __construct()
    {
        $this->vocabularyHiraganas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficulty(): ?Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(?Difficulty $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getHiragana(): ?string
    {
        return $this->hiragana;
    }

    public function setHiragana(string $hiragana): static
    {
        $this->hiragana = $hiragana;

        return $this;
    }

    public function getRomaji(): ?string
    {
        return $this->romaji;
    }

    public function setRomaji(string $romaji): static
    {
        $this->romaji = $romaji;

        return $this;
    }

    public function getFrench(): ?string
    {
        return $this->french;
    }

    public function setFrench(string $french): static
    {
        $this->french = $french;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, VocabularyHiragana>
     */
    public function getVocabularyHiraganas(): Collection
    {
        return $this->vocabularyHiraganas;
    }

    public function addVocabularyHiragana(VocabularyHiragana $vocabularyHiragana): static
    {
        if (!$this->vocabularyHiraganas->contains($vocabularyHiragana)) {
            $this->vocabularyHiraganas->add($vocabularyHiragana);
            $vocabularyHiragana->setVocabulary($this);
        }

        return $this;
    }

    public function removeVocabularyHiragana(VocabularyHiragana $vocabularyHiragana): static
    {
        if ($this->vocabularyHiraganas->removeElement($vocabularyHiragana)) {
            // set the owning side to null (unless already changed)
            if ($vocabularyHiragana->getVocabulary() === $this) {
                $vocabularyHiragana->setVocabulary(null);
            }
        }

        return $this;
    }
}
