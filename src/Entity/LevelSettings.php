<?php

namespace App\Entity;

use App\Repository\LevelSettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelSettingsRepository::class)]
class LevelSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $baseXp = null;

    #[ORM\Column]
    private ?int $increment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseXp(): ?int
    {
        return $this->baseXp;
    }

    public function setBaseXp(int $baseXp): static
    {
        $this->baseXp = $baseXp;

        return $this;
    }

    public function getIncrement(): ?int
    {
        return $this->increment;
    }

    public function setIncrement(int $increment): static
    {
        $this->increment = $increment;

        return $this;
    }
}
