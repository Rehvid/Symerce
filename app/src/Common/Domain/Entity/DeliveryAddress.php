<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use App\Common\Domain\Traits\CreatedAtTrait;
use App\Common\Domain\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class DeliveryAddress
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToOne(targetEntity: Address::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Address $address = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $deliveryInstructions;

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getDeliveryInstructions(): ?string
    {
        return $this->deliveryInstructions;
    }

    public function setDeliveryInstructions(?string $deliveryInstructions): void
    {
        $this->deliveryInstructions = $deliveryInstructions;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
