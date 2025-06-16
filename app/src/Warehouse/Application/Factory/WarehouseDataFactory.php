<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Factory;

use App\Common\Application\Dto\AddressData;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Warehouse\Application\Dto\Request\SaveWarehouseRequest;
use App\Warehouse\Application\Dto\WarehouseData;

final readonly class WarehouseDataFactory
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ) {}

    public function fromRequest(SaveWarehouseRequest $warehouseRequest): WarehouseData
    {
        $country = $this->countryRepository->findById($warehouseRequest->addressRequest->countryIdRequest->getId());
        if (null === $country) {
            throw EntityNotFoundException::for(Country::class, $warehouseRequest->addressRequest->countryIdRequest->getId());
        }

        return new WarehouseData(
            addressData: new AddressData(
                street: $warehouseRequest->addressRequest->street,
                postalCode: $warehouseRequest->addressRequest->postalCode,
                city: $warehouseRequest->addressRequest->city,
                country: $country,
            ),
            name: $warehouseRequest->name,
            isActive: $warehouseRequest->isActive,
            description: $warehouseRequest->description,
        );
    }
}
