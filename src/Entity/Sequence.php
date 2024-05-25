<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\SequenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SequenceRepository::class)]
#[ApiResource]
#[Get(
    uriTemplate: '/sequences/{id}',
    openapiContext: [
        'summary' => 'Récupère une séquence par son identifiant',
        'description' => 'Récupère une séquence par son identifiant',
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
                'description' => 'Séquence récupérée',
                'content' => [
                    'application/ld+json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/Sequence',
                        ],
                    ],
                ],
            ],
            '404' => [
                'description' => 'Séquence non trouvée',
            ],
        ],
    ],
    normalizationContext: ['groups' => ['sequence_read', 'Projet:sequence_read']],
)]
#[GetCollection(
    uriTemplate: '/sequences',
    normalizationContext: ['groups' => ['sequence_read']],
)]
#[GetCollection(
    uriTemplate: '/plans_de_travail/{id}/sequences',
    uriVariables: [
        'id' => new Link(fromProperty: 'sequences', fromClass: PlanDeTravail::class),
    ],
    normalizationContext: ['groups' => ['sequence_read']],
)]
#[Patch(
    normalizationContext: ['groups' => ['sequence_read']],
    denormalizationContext: ['groups' => ['sequence_write']],
    security: "is_granted('ROLE_USER') && object.getPlanDeTravail().getAuteur() == user",
)]
#[Post(
    normalizationContext: ['groups' => ['sequence_read']],
    denormalizationContext: ['groups' => ['sequence_write']],
    security: "is_granted('ROLE_USER')",
)]
#[Delete(
    uriTemplate: '/sequences/{id}',
    requirements: ['id' => '\d+'],
    security: "is_granted('ROLE_USER') && object.getPlanDeTravail().getAuteur() == user",
)]
class Sequence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sequence_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['sequence_read', 'sequence_write'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['sequence_read', 'sequence_write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['sequence_read', 'sequence_write'])]
    private ?\DateTimeInterface $dateDeb = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['sequence_read', 'sequence_write'])]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'sequences')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sequence_read', 'sequence_write'])]
    private ?PlanDeTravail $plan_de_travail = null;

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'sequence')]
    #[Groups(['Projet:sequence_read'])]
    private Collection $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
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

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setSequence($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getSequence() === $this) {
                $projet->setSequence(null);
            }
        }

        return $this;
    }
}
