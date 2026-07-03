<?php

namespace App\Entity;

use App\Repository\ActivityLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityLogRepository::class)]
class ActivityLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'activityLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $player = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activity $activity = null;

    #[ORM\ManyToOne]
    private ?Vocabulary $vocabulary = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Difficulty $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'activityLogs')]
    private ?Session $session = null;

    #[ORM\OneToOne(mappedBy: 'activityLog', cascade: ['persist', 'remove'])]
    private ?XpTransaction $xpTransaction = null;

    #[ORM\Column(length: 20)]
    private ?string $result = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): static
    {
        $this->player = $player;

        return $this;
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

    public function getVocabulary(): ?Vocabulary
    {
        return $this->vocabulary;
    }

    public function setVocabulary(?Vocabulary $vocabulary): static
    {
        $this->vocabulary = $vocabulary;

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

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getXpTransaction(): ?XpTransaction
    {
        return $this->xpTransaction;
    }

    public function setXpTransaction(XpTransaction $xpTransaction): static
    {
        // set the owning side of the relation if necessary
        if ($xpTransaction->getActivityLog() !== $this) {
            $xpTransaction->setActivityLog($this);
        }

        $this->xpTransaction = $xpTransaction;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
