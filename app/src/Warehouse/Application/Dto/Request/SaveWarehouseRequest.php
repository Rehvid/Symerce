<?php

declare (strict_types = 1);

namespace App\Warehouse\Application\Dto\Request;

use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveWarehouseRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2)]
    public string $name;

    public ?string $description;

    public bool $isActive;

    public SaveAddressRequest $addressRequest;

    public function __construct(
        string $name,
        bool $isActive,
        SaveAddressRequest $addressRequest,
        ?string $description = null,
    ) {
        $this->name = $name;
        $this->isActive = $isActive;
        $this->addressRequest = $addressRequest;
        $this->description = $description;
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $addressRequest = new SaveAddressRequest(
            street: $data['street'] ?? null,
            postalCode: $data['postalCode'] ?? null,
            city: $data['city'] ?? null,
            country: $data['country'] ?? null,
        );

        return new self(
            name: $data['name'] ?? null,
            isActive: $data['isActive'] ?? false,
            addressRequest: $addressRequest,
            description: $data['description'] ?? null,
        );
    }
}
