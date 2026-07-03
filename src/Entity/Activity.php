<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\UniqueConstraint(name: 'UNIQ_ACTIVITY_NAME', fields: ['name'])]
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, XpRule>
     */
    #[ORM\OneToMany(targetEntity: XpRule::class, mappedBy: 'activity', orphanRemoval: true)]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $xpRule->setActivity($this);
        }

        return $this;
    }

    public function removeXpRule(XpRule $xpRule): static
    {
        if ($this->xpRules->removeElement($xpRule)) {
            // set the owning side to null (unless already changed)
            if ($xpRule->getActivity() === $this) {
                $xpRule->setActivity(null);
            }
        }

        return $this;
    }
}
