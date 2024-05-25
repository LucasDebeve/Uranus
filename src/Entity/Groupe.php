<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
#[ApiResource]
#[Get(
    uriTemplate: '/groupes/{id}',
    normalizationContext: ['groups' => ['groupe_read']],
    security: 'is_granted("ROLE_USER") && object.getResponsable() == user'
)]
#[GetCollection(
    uriTemplate: '/users/{id}/groupes',
    uriVariables: [
        'id' => new Link(fromProperty: 'mes_groupes', fromClass: User::class),
    ],
    normalizationContext: ['groups' => ['groupe_read']],
)]
#[Patch(
    normalizationContext: ['groups' => ['groupe_read']],
    denormalizationContext: ['groups' => ['groupe_write']],
    security: 'is_granted("ROLE_USER") && object.getResponsable() == user'
)]
#[Post(
    normalizationContext: ['groups' => ['groupe_read']],
    denormalizationContext: ['groups' => ['groupe_write']],
    security: 'is_granted("ROLE_USER")' // Only teachers can create groups
)]
#[Delete(
    uriTemplate: '/groupes/{id}',
    requirements: ['id' => '\d+'],
    security: 'is_granted("ROLE_USER") && object.getResponsable() == user'
)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['groupe_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['Groupe:assignations_read', 'groupe_read', 'groupe_write'])]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'mes_groupes')]
    #[Groups(['groupe_read'])]
    private ?User $responsable = null;

    /**
     * @var Collection<int, AssignationGroupe>
     */
    #[ORM\OneToMany(targetEntity: AssignationGroupe::class, mappedBy: 'groupe', orphanRemoval: true)]
    #[Groups(['groupe_read'])]
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
