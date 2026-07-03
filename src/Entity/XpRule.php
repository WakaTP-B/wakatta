<?php

namespace App\Entity;

use App\Repository\XpRuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XpRuleRepository::class)]
class XpRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xpRules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activity $activity = null;

    #[ORM\ManyToOne(inversedBy: 'xpRules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Difficulty $difficulty = null;

    #[ORM\Column]
    private ?int $xpSuccess = null;

    #[ORM\Column]
    private ?int $xpFailure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
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

    public function getXpSuccess(): ?int
    {
        return $this->xpSuccess;
    }

    public function setXpSuccess(int $xpSuccess): static
    {
        $this->xpSuccess = $xpSuccess;

        return $this;
    }

    public function getXpFailure(): ?int
    {
        return $this->xpFailure;
    }

    public function setXpFailure(int $xpFailure): static
    {
        $this->xpFailure = $xpFailure;

        return $this;
    }
}
