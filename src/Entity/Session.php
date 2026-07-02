<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $player = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $started_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $ended_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_xp = null;

    /**
     * @var Collection<int, ActivityLog>
     */
    #[ORM\OneToMany(targetEntity: ActivityLog::class, mappedBy: 'session')]
    private Collection $activityLogs;

    public function __construct()
    {
        $this->activityLogs = new ArrayCollection();
    }

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

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->started_at;
    }

    public function setStartedAt(\DateTimeImmutable $started_at): static
    {
        $this->started_at = $started_at;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->ended_at;
    }

    public function setEndedAt(\DateTimeImmutable $ended_at): static
    {
        $this->ended_at = $ended_at;

        return $this;
    }

    public function getTotalXp(): ?int
    {
        return $this->total_xp;
    }

    public function setTotalXp(?int $total_xp): static
    {
        $this->total_xp = $total_xp;

        return $this;
    }

    /**
     * @return Collection<int, ActivityLog>
     */
    public function getActivityLogs(): Collection
    {
        return $this->activityLogs;
    }

    public function addActivityLog(ActivityLog $activityLog): static
    {
        if (!$this->activityLogs->contains($activityLog)) {
            $this->activityLogs->add($activityLog);
            $activityLog->setSession($this);
        }

        return $this;
    }

    public function removeActivityLog(ActivityLog $activityLog): static
    {
        if ($this->activityLogs->removeElement($activityLog)) {
            // set the owning side to null (unless already changed)
            if ($activityLog->getSession() === $this) {
                $activityLog->setSession(null);
            }
        }

        return $this;
    }
}
