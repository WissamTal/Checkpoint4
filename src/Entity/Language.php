<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Repos::class, inversedBy="languages", cascade={"persist"}))
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $languageName;

    public function __construct()
    {
        $this->name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Repos[]
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(Repos $name): self
    {
        if (!$this->name->contains($name)) {
            $this->name[] = $name;
        }

        return $this;
    }

    public function removeName(Repos $name): self
    {
        $this->name->removeElement($name);

        return $this;
    }

    public function getLanguageName(): ?string
    {
        return $this->languageName;
    }

    public function setLanguageName(string $languageName): self
    {
        $this->languageName = $languageName;

        return $this;
    }

}
