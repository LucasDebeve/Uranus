<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanDeTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanDeTravailRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['titre' => 'partial'])]
class PlanDeTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    /**
     * @var Collection<int, Sequence>
     */
    #[ORM\OneToMany(targetEntity: Sequence::class, mappedBy: 'plan_de_travail')]
    private Collection $sequences;

    public function __construct()
    {
        $this->sequences = new ArrayCollection();
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
}
