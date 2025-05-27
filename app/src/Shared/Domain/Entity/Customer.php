<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Admin\Domain\Entity\UserToken;
use App\Admin\Domain\Traits\ActiveTrait;
use App\Admin\Domain\Traits\CreatedAtTrait;
use App\Admin\Domain\Traits\UpdatedAtTrait;
use App\Shared\Infrastructure\Repository\CustomerDoctrineRepository;
use App\Shop\Domain\Entity\Embeddables\ContactDetails;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CustomerDoctrineRepository::class)]
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


    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    /** @var array<int|string> */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /** @var Collection<int, UserToken> */
    #[ORM\OneToMany(targetEntity: UserToken::class, mappedBy:'user', cascade:['remove'])]
    private Collection $tokens;

    #[ORM\ManyToOne(targetEntity: DeliveryAddress::class, cascade:['persist'])]
    #[ORM\JoinColumn(name: "delivery_address_id", referencedColumnName: "id")]
    private ?DeliveryAddress $deliveryAddress;

    #[ORM\ManyToOne(targetEntity: InvoiceAddress::class, cascade:['persist'])]
    #[ORM\JoinColumn(name: "invoice_address_id", referencedColumnName: "id")]
    private ?InvoiceAddress $invoiceAddress;

    #[ORM\Embedded(class: ContactDetails::class, columnPrefix: false)]
    private ContactDetails $contactDetails;

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
        return $this->contactDetails->getEmail();
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

    public function getDeliveryAddress(): ?DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?DeliveryAddress $deliveryAddress): void
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    public function getInvoiceAddress(): ?InvoiceAddress
    {
        return $this->invoiceAddress;
    }

    public function setInvoiceAddress(?InvoiceAddress $invoiceAddress): void
    {
        $this->invoiceAddress = $invoiceAddress;
    }

    public function getContactDetails(): ContactDetails
    {
        return $this->contactDetails;
    }

    public function setContactDetails(ContactDetails $contactDetails): void
    {
        $this->contactDetails = $contactDetails;
    }
}
