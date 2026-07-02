<?php

namespace App\Entity;

use App\Repository\HiraganaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HiraganaRepository::class)]
class Hiragana
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $character = null;

    #[ORM\Column(length: 10)]
    private ?string $romaji = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?int $stroke_count = null;

    /**
     * @var Collection<int, HiraganaGroupMember>
     */
    #[ORM\OneToMany(targetEntity: HiraganaGroupMember::class, mappedBy: 'hiragana', orphanRemoval: true)]
    private Collection $hiraganaGroupMembers;

    public function __construct()
    {
        $this->hiraganaGroupMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): ?string
    {
        return $this->character;
    }

    public function setCharacter(string $character): static
    {
        $this->character = $character;

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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getStrokeCount(): ?int
    {
        return $this->stroke_count;
    }

    public function setStrokeCount(int $stroke_count): static
    {
        $this->stroke_count = $stroke_count;

        return $this;
    }

    /**
     * @return Collection<int, HiraganaGroupMember>
     */
    public function getHiraganaGroupMembers(): Collection
    {
        return $this->hiraganaGroupMembers;
    }

    public function addHiraganaGroupMember(HiraganaGroupMember $hiraganaGroupMember): static
    {
        if (!$this->hiraganaGroupMembers->contains($hiraganaGroupMember)) {
            $this->hiraganaGroupMembers->add($hiraganaGroupMember);
            $hiraganaGroupMember->setHiragana($this);
        }

        return $this;
    }

    public function removeHiraganaGroupMember(HiraganaGroupMember $hiraganaGroupMember): static
    {
        if ($this->hiraganaGroupMembers->removeElement($hiraganaGroupMember)) {
            // set the owning side to null (unless already changed)
            if ($hiraganaGroupMember->getHiragana() === $this) {
                $hiraganaGroupMember->setHiragana(null);
            }
        }

        return $this;
    }
}
