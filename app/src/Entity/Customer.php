<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CustomerRepository;
use App\Traits\ActiveTrait;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'This account already exists.')]
class Customer implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    /** @var array<int|string> */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /** @var Collection<int, UserToken> */
    #[ORM\OneToMany(targetEntity: UserToken::class, mappedBy:'user', cascade:['remove'])]
    private Collection $tokens;

    #[ORM\ManyToOne(targetEntity: DeliveryAddress::class)]
    #[ORM\JoinColumn(name: "delivery_address_id", referencedColumnName: "id")]
    private ?DeliveryAddress $deliveryAddress;

    #[ORM\ManyToOne(targetEntity: InvoiceAddress::class)]
    #[ORM\JoinColumn(name: "invoice_address_id", referencedColumnName: "id")]
    private ?InvoiceAddress $invoiceAddress;

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

    /** @param array<int|string> $roles */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
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
}
