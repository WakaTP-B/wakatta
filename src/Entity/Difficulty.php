<?php

namespace App\Entity;

use App\Repository\DifficultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DifficultyRepository::class)]
class Difficulty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $label_jp = null;

    /**
     * @var Collection<int, XpRule>
     */
    #[ORM\OneToMany(targetEntity: XpRule::class, mappedBy: 'difficulty')]
    private Collection $xpRules;

    public function __construct()
    {
        $this->xpRules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLabelJp(): ?string
    {
        return $this->label_jp;
    }

    public function setLabelJp(string $label_jp): static
    {
        $this->label_jp = $label_jp;

        return $this;
    }

    /**
     * @return Collection<int, XpRule>
     */
    public function getXpRules(): Collection
    {
        return $this->xpRules;
    }

    public function addXpRule(XpRule $xpRule): static
    {
        if (!$this->xpRules->contains($xpRule)) {
            $this->xpRules->add($xpRule);
            $xpRule->setDifficulty($this);
        }

        return $this;
    }

    public function removeXpRule(XpRule $xpRule): static
    {
        if ($this->xpRules->removeElement($xpRule)) {
            // set the owning side to null (unless already changed)
            if ($xpRule->getDifficulty() === $this) {
                $xpRule->setDifficulty(null);
            }
        }

        return $this;
    }
}
