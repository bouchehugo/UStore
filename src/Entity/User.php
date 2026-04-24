<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'CLIENT')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'iduser', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'prenom', type: 'string', length: 50)]
    private string $firstname;

    #[ORM\Column(name: 'nom', type: 'string', length: 50)]
    private string $lastname;

    #[ORM\Column(name: 'tel', type: 'string', length: 50, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(name: 'email', type: 'string', length: 50, unique: true)]
    private string $email;

    #[ORM\Column(name: 'mdp', type: 'string', length: 50)]
    private string $password;

    #[ORM\Column(name: 'role', type: 'string', length: 10)]
    private string $role = 'user';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        if ($this->role === 'admin') {
            return ['ROLE_ADMIN'];
        }

        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}

