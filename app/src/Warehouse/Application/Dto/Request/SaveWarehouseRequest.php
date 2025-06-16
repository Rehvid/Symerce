<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Dto\Request;

use App\Common\Application\Dto\Request\Address\SaveAddressRequest;
use App\Common\Infrastructure\Utils\BoolHelper;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveWarehouseRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\When(
        expression: 'this.description !== null',
        constraints: [
            new Assert\Length(min: 3),
        ]
    )]
    public ?string $description;


    public bool $isActive;

    #[Assert\Valid]
    public SaveAddressRequest $addressRequest;

    public function __construct(
        string $name,
        mixed $isActive,
        string $street,
        string $postalCode,
        string $city,
        int|string|null $countryId,
        ?string $description,
    ) {
        $this->name = $name;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->addressRequest = new SaveAddressRequest(
            street: $street,
            postalCode: $postalCode,
            city: $city,
            countryId: $countryId,
        );
        $this->description = $description;
    }
}
