<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Player implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    private array $roles = [];

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Pyramid::class, orphanRemoval: true)]
    private Collection $pyramids_created;

    #[ORM\ManyToMany(targetEntity: Pyramid::class, mappedBy: 'players')]
    private Collection $pyramids_played;

    public function __construct()
    {
        $this->pyramids_created = new ArrayCollection();
        $this->pyramids_played = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_PLAYER
        $roles[] = 'ROLE_PLAYER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Pyramid>
     */
    public function getPyramidsCreated(): Collection
    {
        return $this->pyramids_created;
    }

    public function addPyramidsCreated(Pyramid $pyramidsCreated): self
    {
        if (!$this->pyramids_created->contains($pyramidsCreated)) {
            $this->pyramids_created->add($pyramidsCreated);
            $pyramidsCreated->setAuthor($this);
        }

        return $this;
    }

    public function removePyramidsCreated(Pyramid $pyramidsCreated): self
    {
        if ($this->pyramids_created->removeElement($pyramidsCreated)) {
            // set the owning side to null (unless already changed)
            if ($pyramidsCreated->getAuthor() === $this) {
                $pyramidsCreated->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pyramid>
     */
    public function getPyramidsPlayed(): Collection
    {
        return $this->pyramids_played;
    }

    public function addPyramidsPlayed(Pyramid $pyramidsPlayed): self
    {
        if (!$this->pyramids_played->contains($pyramidsPlayed)) {
            $this->pyramids_played->add($pyramidsPlayed);
            $pyramidsPlayed->addPlayer($this);
        }

        return $this;
    }

    public function removePyramidsPlayed(Pyramid $pyramidsPlayed): self
    {
        if ($this->pyramids_played->removeElement($pyramidsPlayed)) {
            $pyramidsPlayed->removePlayer($this);
        }

        return $this;
    }
}
