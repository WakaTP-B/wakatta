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
    private ?int $xp_success = null;

    #[ORM\Column]
    private ?int $xp_failure = null;

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
        return $this->xp_success;
    }

    public function setXpSuccess(int $xp_success): static
    {
        $this->xp_success = $xp_success;

        return $this;
    }

    public function getXpFailure(): ?int
    {
        return $this->xp_failure;
    }

    public function setXpFailure(int $xp_failure): static
    {
        $this->xp_failure = $xp_failure;

        return $this;
    }
}
