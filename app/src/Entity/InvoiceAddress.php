<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Embeddables\Address;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class InvoiceAddress
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Embedded(class: Address::class, columnPrefix: false)]
    private Address $address;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $companyTaxId;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $companyName;

    public function getCompanyTaxId(): ?string
    {
        return $this->companyTaxId;
    }

    public function setCompanyTaxId(?string $companyTaxId): void
    {
        $this->companyTaxId = $companyTaxId;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }


}
