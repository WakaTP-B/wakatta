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
    private ?int $base_xp = null;

    #[ORM\Column]
    private ?int $increment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseXp(): ?int
    {
        return $this->base_xp;
    }

    public function setBaseXp(int $base_xp): static
    {
        $this->base_xp = $base_xp;

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
