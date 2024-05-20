<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SequenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SequenceRepository::class)]
#[ApiResource]
class Sequence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDeb = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'sequences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PlanDeTravail $plan_de_travail = null;

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

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): static
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getPlanDeTravail(): ?PlanDeTravail
    {
        return $this->plan_de_travail;
    }

    public function setPlanDeTravail(?PlanDeTravail $plan_de_travail): static
    {
        $this->plan_de_travail = $plan_de_travail;

        return $this;
    }
}
