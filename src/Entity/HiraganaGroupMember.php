<?php

namespace App\Entity;

use App\Repository\HiraganaGroupMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HiraganaGroupMemberRepository::class)]
class HiraganaGroupMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'hiraganaGroupMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hiragana $hiragana = null;

    #[ORM\ManyToOne(inversedBy: 'hiraganaGroupMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HiraganaGroup $hiraganaGroup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHiragana(): ?Hiragana
    {
        return $this->hiragana;
    }

    public function setHiragana(?Hiragana $hiragana): static
    {
        $this->hiragana = $hiragana;

        return $this;
    }

    public function getHiraganaGroup(): ?HiraganaGroup
    {
        return $this->hiraganaGroup;
    }

    public function setHiraganaGroup(?HiraganaGroup $hiraganaGroup): static
    {
        $this->hiraganaGroup = $hiraganaGroup;

        return $this;
    }
}
