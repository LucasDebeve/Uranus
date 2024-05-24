<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\AssignationGroupeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AssignationGroupeRepository::class)]
#[ApiResource]
#[GetCollection(
    uriTemplate: '/groupes/{id}/assignations',
    uriVariables: [
        'id' => new Link(fromProperty: 'assignations', fromClass: Groupe::class),
    ],
    normalizationContext: ['groups' => ['assignations_read']],
)]
class AssignationGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['assignations_read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignations_read'])]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignations_read'])]
    private ?User $eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): static
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getEleve(): ?User
    {
        return $this->eleve;
    }

    public function setEleve(?User $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
}
