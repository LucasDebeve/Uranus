<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\MeProvider;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ApiResource(normalizationContext: ['groups' => ['User_read']])]
#[Get]
#[Get(
    uriTemplate: '/me',
    normalizationContext: ['groups' => ['User_read', 'User_me']],
    security: 'is_granted("ROLE_USER")',
    provider: MeProvider::class)]
#[Patch(
    normalizationContext: ['groups' => ['User_read', 'User_me']],
    denormalizationContext: ['groups' => ['User_write']],
    security: 'is_granted("ROLE_USER") && object == user',
    processor: UserPasswordHasher::class)]
#[Post(
    normalizationContext: ['groups' => ['User_read', 'User_me']],
    denormalizationContext: ['groups' => ['User_write']],
    security: 'is_granted("ROLE_PROF")',
    processor: UserPasswordHasher::class
)]
#[Delete(
    uriTemplate: '/users/{id}',
    requirements: ['id' => '\d+'],
    security: 'is_granted("ROLE_PROF")'
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['User_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['User_read'])]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['User_write'])]
    #[Groups(['User_write'])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['User_read', 'User_write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['User_read', 'User_write'])]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $avatar;

    /**
     * @var Collection<int, PlanDeTravail>
     */
    #[ORM\OneToMany(targetEntity: PlanDeTravail::class, mappedBy: 'auteur')]
    #[Groups(['User_PlanDeTravail_read'])]
    private Collection $plansDeTravail;

    /**
     * @var Collection<int, Suivi>
     */
    #[ORM\OneToMany(targetEntity: Suivi::class, mappedBy: 'eleve', orphanRemoval: true)]
    private Collection $suivis;

    /**
     * @var Collection<int, Groupe>
     */
    #[ORM\OneToMany(targetEntity: Groupe::class, mappedBy: 'responsable')]
    private Collection $mes_groupes;

    public function __construct()
    {
        $this->plansDeTravail = new ArrayCollection();
        $this->suivis = new ArrayCollection();
        $this->mes_groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, PlanDeTravail>
     */
    public function getPlansDeTravail(): Collection
    {
        return $this->plansDeTravail;
    }

    public function addPlansDeTravail(PlanDeTravail $plansDeTravail): static
    {
        if (!$this->plansDeTravail->contains($plansDeTravail)) {
            $this->plansDeTravail->add($plansDeTravail);
            $plansDeTravail->setAuteur($this);
        }

        return $this;
    }

    public function removePlansDeTravail(PlanDeTravail $plansDeTravail): static
    {
        if ($this->plansDeTravail->removeElement($plansDeTravail)) {
            // set the owning side to null (unless already changed)
            if ($plansDeTravail->getAuteur() === $this) {
                $plansDeTravail->setAuteur(null);
            }
        }

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
            $suivi->setEleve($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): static
    {
        if ($this->suivis->removeElement($suivi)) {
            // set the owning side to null (unless already changed)
            if ($suivi->getEleve() === $this) {
                $suivi->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Groupe>
     */
    public function getMesGroupes(): Collection
    {
        return $this->mes_groupes;
    }

    public function addMesGroupe(Groupe $mesGroupe): static
    {
        if (!$this->mes_groupes->contains($mesGroupe)) {
            $this->mes_groupes->add($mesGroupe);
            $mesGroupe->setResponsable($this);
        }

        return $this;
    }

    public function removeMesGroupe(Groupe $mesGroupe): static
    {
        if ($this->mes_groupes->removeElement($mesGroupe)) {
            // set the owning side to null (unless already changed)
            if ($mesGroupe->getResponsable() === $this) {
                $mesGroupe->setResponsable(null);
            }
        }

        return $this;
    }
}
