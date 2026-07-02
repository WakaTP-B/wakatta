<?php

namespace App\Entity;

use App\Repository\HiraganaGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HiraganaGroupRepository::class)]
class HiraganaGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, HiraganaGroupMember>
     */
    #[ORM\OneToMany(targetEntity: HiraganaGroupMember::class, mappedBy: 'hiraganaGroup', orphanRemoval: true)]
    private Collection $hiraganaGroupMembers;

    public function __construct()
    {
        $this->hiraganaGroupMembers = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
     * @return Collection<int, HiraganaGroupMember>
     */
    public function getHiraganaGroupMembers(): Collection
    {
        return $this->hiraganaGroupMembers;
    }

    public function addHiraganaGroupMember(HiraganaGroupMember $hiraganaGroupMember): static
    {
        if (!$this->hiraganaGroupMembers->contains($hiraganaGroupMember)) {
            $this->hiraganaGroupMembers->add($hiraganaGroupMember);
            $hiraganaGroupMember->setHiraganaGroup($this);
        }

        return $this;
    }

    public function removeHiraganaGroupMember(HiraganaGroupMember $hiraganaGroupMember): static
    {
        if ($this->hiraganaGroupMembers->removeElement($hiraganaGroupMember)) {
            // set the owning side to null (unless already changed)
            if ($hiraganaGroupMember->getHiraganaGroup() === $this) {
                $hiraganaGroupMember->setHiraganaGroup(null);
            }
        }

        return $this;
    }
}
