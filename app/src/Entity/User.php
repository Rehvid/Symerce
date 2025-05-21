<?php

declare(strict_types=1);

namespace App\Entity;

use App\Admin\Domain\Contract\HasFileInterface;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\CreatedAtTrait;
use App\Admin\Domain\Traits\UpdatedAtTrait;
use App\Admin\Infrastructure\Repository\UserDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserDoctrineRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'This account already exists.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, HasFileInterface
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use ActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $firstname;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $surname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;


    /** @var array<int|string> */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /** @var Collection<int, UserToken> */
    #[ORM\OneToMany(targetEntity: UserToken::class, mappedBy:'user', cascade:['remove'])]
    private Collection $tokens;

    #[ORM\ManyToOne(targetEntity: File::class, cascade:['persist'])]
    #[ORM\JoinColumn(name: 'avatar_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?File $avatar = null;

    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /** @return array<int|string>  */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        /* @phpstan-ignore-next-line */
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

    /** @param array<int|string> $roles */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /** @return Collection<int, UserToken>  */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function getFullName(): string
    {
        return $this->firstname.' '.$this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function addUserToken(UserToken $token): void
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens->add($token);
        }
    }

    public function removeUserToken(UserToken $token): void
    {
        if ($this->tokens->contains($token)) {
            $this->tokens->removeElement($token);
        }
    }

    public function getAvatar(): ?File
    {
        return $this->getFile(); //TODO: Change it later
    }

    public function setAvatar(?File $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function setFile(File $file): void
    {
        $this->avatar = $file;
    }

    public function getFile(): ?File
    {
        return $this->avatar;
    }
}
