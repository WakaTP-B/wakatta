<?php

namespace App\Entity;

use App\Repository\XpTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XpTransactionRepository::class)]
class XpTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xpTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $player = null;

    #[ORM\OneToOne(inversedBy: 'xpTransaction', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActivityLog $activityLog = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

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

    public function getActivityLog(): ?ActivityLog
    {
        return $this->activityLog;
    }

    public function setActivityLog(ActivityLog $activityLog): static
    {
        $this->activityLog = $activityLog;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

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
}
