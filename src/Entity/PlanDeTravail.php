<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\PlanDeTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlanDeTravailRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['titre' => 'partial'])]
#[Get(
    uriTemplate: '/plans_de_travail/{id}',
    openapiContext: [
        'summary' => 'Récupère un plan de travail par son identifiant',
        'description' => 'Récupère un plan de travail par son identifiant',
        'parameters' => [
            [
                'in' => 'path',
                'name' => 'id',
                'required' => true,
                'type' => 'integer',
            ],
        ],
        'responses' => [
            '200' => [
                'description' => 'Plan de travail récupéré',
                'content' => [
                    'application/ld+json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/PlanDeTravail',
                        ],
                    ],
                ],
            ],
            '404' => [
                'description' => 'Plan de travail non trouvé',
            ],
        ],
    ],
    normalizationContext: ['groups' => ['PlanDeTravail_read']],
    security: "is_granted('ROLE_USER') && object.getAuteur() == user",
)]
#[GetCollection(
    uriTemplate: '/plans_de_travail',
    openapiContext: [
        'summary' => 'Récupère la liste des plans de travail',
        'description' => 'Récupère la liste des plans de travail',
        'responses' => [
            '200' => [
                'description' => 'Liste des plans de travail',
                'content' => [
                    'application/ld+json' => [
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/components/schemas/PlanDeTravail',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    normalizationContext: ['groups' => ['PlanDeTravail_read']],
    security: "is_granted('ROLE_USER')",
)]
#[GetCollection(
    uriTemplate: '/users/{id}/plans_de_travail',
    uriVariables: [
        'id' => new Link(fromProperty: 'plansDeTravail', fromClass: User::class),
    ],
    normalizationContext: ['groups' => ['User:PlanDeTravail_read']],
)]
#[Patch(
    uriTemplate: '/plans_de_travail/{id}',
    openapiContext: [
        'summary' => 'Modifie un plan de travail',
        'description' => 'Modifie un plan de travail',
        'parameters' => [
            [
                'in' => 'path',
                'name' => 'id',
                'required' => true,
                'type' => 'integer',
            ],
        ],
        'responses' => [
            '200' => [
                'description' => 'Plan de travail modifié',
                'content' => [
                    'application/ld+json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/PlanDeTravail',
                        ],
                    ],
                ],
            ],
            '404' => [
                'description' => 'Plan de travail non trouvé',
            ],
        ],
    ],
    normalizationContext: ['groups' => ['PlanDeTravail_read']],
    denormalizationContext: ['groups' => ['PlanDeTravail_write']],
    security: "is_granted('ROLE_USER') && object.getAuteur() == user",
)]
#[Post(
    uriTemplate: '/plans_de_travail',
    normalizationContext: ['groups' => ['PlanDeTravail_read']],
    denormalizationContext: ['groups' => ['PlanDeTravail_write']],
    security: "is_granted('ROLE_PROF')",
)]
class PlanDeTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['PlanDeTravail_read', 'User:PlanDeTravail_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['PlanDeTravail_read', 'PlanDeTravail_write', 'User:PlanDeTravail_read'])]
    private ?string $titre = null;

    /**
     * @var Collection<int, Sequence>
     */
    #[ORM\OneToMany(targetEntity: Sequence::class, mappedBy: 'plan_de_travail')]
    #[Groups(['PlanDeTravail_read', 'PlanDeTravail_write', 'User:PlanDeTravail_read'])]
    private Collection $sequences;

    #[ORM\ManyToOne(inversedBy: 'plansDeTravail')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['PlanDeTravail_read', 'User:PlanDeTravail_read'])]
    private ?User $auteur = null;

    /**
     * @var Collection<int, Suivi>
     */
    #[ORM\OneToMany(targetEntity: Suivi::class, mappedBy: 'plan_de_travail', orphanRemoval: true)]
    private Collection $suivis;

    public function __construct()
    {
        $this->sequences = new ArrayCollection();
        $this->suivis = new ArrayCollection();
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

    /**
     * @return Collection<int, Sequence>
     */
    public function getSequences(): Collection
    {
        return $this->sequences;
    }

    public function addSequence(Sequence $sequence): static
    {
        if (!$this->sequences->contains($sequence)) {
            $this->sequences->add($sequence);
            $sequence->setPlanDeTravail($this);
        }

        return $this;
    }

    public function removeSequence(Sequence $sequence): static
    {
        if ($this->sequences->removeElement($sequence)) {
            // set the owning side to null (unless already changed)
            if ($sequence->getPlanDeTravail() === $this) {
                $sequence->setPlanDeTravail(null);
            }
        }

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

    /**
     * @return Collection<int, Suivi>
     */
    public function getSuivis(): Collection
    {
        return $this->suivis;
    }

    public function addSuivi(Suivi $suivi): static
    {
        if (!$this->suivis->contains($suivi)) {
            $this->suivis->add($suivi);
            $suivi->setPlanDeTravail($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): static
    {
        if ($this->suivis->removeElement($suivi)) {
            // set the owning side to null (unless already changed)
            if ($suivi->getPlanDeTravail() === $this) {
                $suivi->setPlanDeTravail(null);
            }
        }

        return $this;
    }
}
