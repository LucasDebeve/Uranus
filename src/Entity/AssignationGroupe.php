<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
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
    normalizationContext: ['groups' => ['User:assignations_read']],
)]
#[GetCollection(
    uriTemplate: '/users/{id}/assignations',
    uriVariables: [
        'id' => new Link(fromProperty: 'assignations', fromClass: User::class),
    ],
    normalizationContext: ['groups' => ['Groupe:assignations_read']],
)]
// Seulement le responsable du groupe peut créer des assignations à ce groupe
#[Patch(
    normalizationContext: ['groups' => ['assignations_read']],
    denormalizationContext: ['groups' => ['assignations_write']],
    security: 'is_granted("ROLE_USER") && object.getGroupe().getResponsable() == user'
)]
#[Post(
    openapiContext: [
        'summary' => 'Assigner un élève à un groupe',
        'description' => 'Assigner un élève à un groupe',
        'requestBody' => [
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'groupe' => ['type' => 'string'],
                            'eleve' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ],
    ],
    normalizationContext: ['groups' => ['assignations_read']],
    denormalizationContext: ['groups' => ['assignations_write']],
    security: 'is_granted("ROLE_USER") && object.getGroupe().getResponsable() == user'
)]
#[Delete(
    uriTemplate: '/assignations/{id}',
    requirements: ['id' => '\d+'],
    security: 'is_granted("ROLE_USER") && object.getGroupe().getResponsable() == user'
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
    #[Groups(['assignations_read', 'Groupe:assignations_read', 'assignations_write'])]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignations_read', 'User:assignations_read', 'groupe_read', 'assignations_write'])]
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
