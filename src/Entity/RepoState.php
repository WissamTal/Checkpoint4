<?php

namespace App\Entity;

use App\Repository\RepoStateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepoStateRepository::class)
 */
class RepoState
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Repos::class, mappedBy="repoState")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->state = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Repos[]
     */
    public function getState(): Collection
    {
        return $this->state;
    }

    public function addState(Repos $state): self
    {
        if (!$this->state->contains($state)) {
            $this->state[] = $state;
            $state->setRepoState($this);
        }

        return $this;
    }

    public function removeState(Repos $state): self
    {
        if ($this->state->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getRepoState() === $this) {
                $state->setRepoState(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
