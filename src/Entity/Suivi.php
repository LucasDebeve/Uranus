<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\SuiviRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SuiviRepository::class)]
#[UniqueEntity(fields: ['eleve_id', 'plan_de_travail_id'], message: 'Un suivi existe déjà pour cet élève et ce plan de travail')]
#[ApiResource]
#[GetCollection(
    uriTemplate: '/plans_de_travail/{id}/suivis',
    uriVariables: [
        'id' => new Link(fromProperty: 'suivis', fromClass: PlanDeTravail::class),
    ],
    normalizationContext: ['groups' => ['PlanDeTravail:Suivi_read']],
)]
#[GetCollection(
    uriTemplate: '/users/{id}/suivis',
    uriVariables: [
        'id' => new Link(fromProperty: 'suivis', fromClass: User::class),
    ],
    normalizationContext: ['groups' => ['User:Suivi_read']],
)]
#[Get(

)]
class Suivi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['PlanDeTravail:Suivi_read', 'User:Suivi_read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'suivis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['PlanDeTravail:Suivi_read', 'User:Suivi_read'])]
    private ?User $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'suivis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['PlanDeTravail:Suivi_read', 'User:Suivi_read'])]
    private ?PlanDeTravail $plan_de_travail = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 100)]
    #[Groups(['PlanDeTravail:Suivi_read', 'User:Suivi_read'])]
    private ?int $progression = null;

    public function __construct()
    {
        $this->progression = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlanDeTravail(): ?PlanDeTravail
    {
        return $this->plan_de_travail;
    }

    public function setPlanDeTravail(?PlanDeTravail $plan_de_travail): static
    {
        $this->plan_de_travail = $plan_de_travail;

        return $this;
    }

    public function getProgression(): ?int
    {
        return $this->progression;
    }

    public function setProgression(int $progression): static
    {
        $this->progression = $progression;

        return $this;
    }
}
