<?php

namespace App\Entity;

use App\Repository\AccessoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessoireRepository::class)]
class Accessoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAccessoire = null;

    #[ORM\Column(length: 255)]
    private ?string $typeAccessoire = null;

    #[ORM\Column]
    private ?int $prixAccessoire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $visuelAccessoire = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'possession')]
    private Collection $utilisateursQuiPossedent;

    public function __construct()
    {
        $this->utilisateursQuiPossedent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAccessoire(): ?string
    {
        return $this->nomAccessoire;
    }

    public function setNomAccessoire(string $nomAccessoire): static
    {
        $this->nomAccessoire = $nomAccessoire;

        return $this;
    }

    public function getTypeAccessoire(): ?string
    {
        return $this->typeAccessoire;
    }

    public function setTypeAccessoire(string $typeAccessoire): static
    {
        $this->typeAccessoire = $typeAccessoire;

        return $this;
    }

    public function getPrixAccessoire(): ?int
    {
        return $this->prixAccessoire;
    }

    public function setPrixAccessoire(int $prixAccessoire): static
    {
        $this->prixAccessoire = $prixAccessoire;

        return $this;
    }

    public function getVisuelAccessoire(): ?string
    {
        return $this->visuelAccessoire;
    }

    public function setVisuelAccessoire(?string $visuelAccessoire): static
    {
        $this->visuelAccessoire = $visuelAccessoire;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateursQuiPossedent(): Collection
    {
        return $this->utilisateursQuiPossedent;
    }

    public function addUtilisateursQuiPossedent(Utilisateur $utilisateursQuiPossedent): static
    {
        if (!$this->utilisateursQuiPossedent->contains($utilisateursQuiPossedent)) {
            $this->utilisateursQuiPossedent->add($utilisateursQuiPossedent);
            $utilisateursQuiPossedent->addPossession($this);
        }

        return $this;
    }

    public function removeUtilisateursQuiPossedent(Utilisateur $utilisateursQuiPossedent): static
    {
        if ($this->utilisateursQuiPossedent->removeElement($utilisateursQuiPossedent)) {
            $utilisateursQuiPossedent->removePossession($this);
        }

        return $this;
    }
}
