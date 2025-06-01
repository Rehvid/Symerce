<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Factory;

use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\DTO\AddressData;
use App\Warehouse\Application\Dto\Request\SaveWarehouseRequest;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class WarehouseDataFactory
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ) {}

    public function fromRequest(SaveWarehouseRequest $warehouseRequest): WarehouseData
    {
        return new WarehouseData(
            addressData: new AddressData(
                street: $warehouseRequest->addressRequest->street,
                postalCode: $warehouseRequest->addressRequest->postalCode,
                city: $warehouseRequest->addressRequest->city,
                country: $this->countryRepository->findById($warehouseRequest->addressRequest->country),
            ),
            name: $warehouseRequest->name,
            isActive: $warehouseRequest->isActive,
            description: $warehouseRequest->description,
        );
    }
}
