<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Entity\Warehouse;
use App\Common\Infrastructure\Utils\ArrayUtils;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Warehouse\Application\Dto\Response\WarehouseFormContextResponse;
use App\Warehouse\Application\Dto\Response\WarehouseFormResponse;
use App\Warehouse\Application\Dto\Response\WarehouseListResponse;

final readonly class WarehouseAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private CountryRepositoryInterface $countryRepository,
    ) {

    }

    public function toListResponse(array $paginatedData): array
    {
        $collection = array_map(
            fn (Warehouse $warehouse) => $this->createWarehouseListResponse($warehouse),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($collection);
    }

    public function toFormContextResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            context: $this->createWarehouseFormContextResponse()
        );
    }

    private function createWarehouseFormContextResponse(): WarehouseFormContextResponse
    {
        return new WarehouseFormContextResponse(
            availableCountries: $this->getAvailableCountries()
        );
    }

    private function createWarehouseListResponse(Warehouse $warehouse): WarehouseListResponse
    {
        return new WarehouseListResponse(
            id: (int) $warehouse->getId(),
            name: $warehouse->getName(),
            fullAddress: $warehouse->getAddress()->getFullAddress(),
            isActive: $warehouse->isActive(),
        );
    }

    public function toFormDataResponse(Warehouse $warehouse): array
    {
        $address = $warehouse->getAddress();

        return $this->responseHelperAssembler->wrapFormResponse(
            data: new WarehouseFormResponse(
                name: $warehouse->getName(),
                description: $warehouse->getDescription(),
                isActive: $warehouse->isActive(),
                street: $address->getStreet(),
                postalCode: $address->getPostalCode(),
                city: $address->getCity(),
                countryId: (int) $address->getCountry()->getId()
            ),
            context: $this->createWarehouseFormContextResponse()
        );
    }

    private function getAvailableCountries(): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: $this->countryRepository->findBy(['isActive' => true]),
            labelCallback: fn (Country $country) => $country->getName(),
            valueCallback: fn (Country $country) => $country->getId()
        );
    }
}
