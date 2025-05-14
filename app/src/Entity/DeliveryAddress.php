<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Embeddables\Address;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class DeliveryAddress extends Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $deliveryInstructions;

    public function getAddress(): Address
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
}
