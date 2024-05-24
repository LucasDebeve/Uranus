<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
#[ApiResource]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'mes_groupes')]
    private ?User $responsable = null;

    /**
     * @var Collection<int, AssignationGroupe>
     */
    #[ORM\OneToMany(targetEntity: AssignationGroupe::class, mappedBy: 'groupe', orphanRemoval: true)]
    private Collection $assignations;

    public function __construct()
    {
        $this->assignations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    public function setResponsable(?User $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection<int, AssignationGroupe>
     */
    public function getAssignations(): Collection
    {
        return $this->assignations;
    }

    public function addAssignation(AssignationGroupe $assignation): static
    {
        if (!$this->assignations->contains($assignation)) {
            $this->assignations->add($assignation);
            $assignation->setGroupe($this);
        }

        return $this;
    }

    public function removeAssignation(AssignationGroupe $assignation): static
    {
        if ($this->assignations->removeElement($assignation)) {
            // set the owning side to null (unless already changed)
            if ($assignation->getGroupe() === $this) {
                $assignation->setGroupe(null);
            }
        }

        return $this;
    }
}
