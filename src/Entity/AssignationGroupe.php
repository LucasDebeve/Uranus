<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssignationGroupeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignationGroupeRepository::class)]
#[ApiResource]
class AssignationGroupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupe $groupe = null;

    #[ORM\ManyToOne(inversedBy: 'assignations')]
    #[ORM\JoinColumn(nullable: false)]
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
