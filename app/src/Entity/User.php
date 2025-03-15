<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\CreatedAtTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'This account already exists.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "bigint")]
    private int $id;

    #[ORM\Column(type: "string", unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $password;

    #[ORM\Column(type: "boolean", nullable: false, options: ['default' => false])]
    private bool $isActive = false;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    private string $plainPassword;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void { }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
