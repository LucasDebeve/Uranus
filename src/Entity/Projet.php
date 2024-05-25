<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
#[ApiResource]
#[Get(
    uriTemplate: '/projets/{id}',
    normalizationContext: ['groups' => ['projet_read']],
)]
#[GetCollection(
    uriTemplate: '/sequences/{id}/projets',
    uriVariables: [
        'id' => new Link(fromProperty: 'projets', fromClass: Sequence::class),
    ],
    normalizationContext: ['groups' => ['projet_read']],
)]
#[GetCollection(
    uriTemplate: '/projets',
    normalizationContext: ['groups' => ['projet_read']],
)]
#[Patch(
    normalizationContext: ['groups' => ['projet_read']],
    denormalizationContext: ['groups' => ['projet_write']],
    security: 'is_granted("ROLE_USER") && object.getAuteur() == user',
)]
#[Post(
    normalizationContext: ['groups' => ['projet_read']],
    denormalizationContext: ['groups' => ['projet_write']],
    security: 'is_granted("ROLE_USER")',
)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['projet_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['projet_read', 'projet_write'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['projet_read', 'projet_write'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[Groups(['projet_read', 'projet_write'])]
    private ?Sequence $sequence = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['projet_read'])]
    private ?User $auteur = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSequence(): ?Sequence
    {
        return $this->sequence;
    }

    public function setSequence(?Sequence $sequence): static
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }
}
