<?php

declare(strict_types=1);

namespace App\Country\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\Country;
use App\Country\Application\Dto\Response\CountryFormResponse;
use App\Country\Application\Dto\Response\CountryListResponse;

final readonly class CountryAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $collection = array_map(
            fn (Country $country) => $this->createCountryListResponse($country),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($collection);
    }

    private function createCountryListResponse(Country $country): CountryListResponse
    {
        return new CountryListResponse(
            id: $country->getId(),
            name: $country->getName(),
            code: $country->getCode(),
            isActive: $country->isActive()
        );
    }

    public function toFormResponse(Country $country): array
    {
        $response = new CountryFormResponse(
            id: $country->getId(),
            name: $country->getName(),
            code: $country->getCode(),
            isActive: $country->isActive(),
        );

        return $this->responseHelperAssembler->wrapFormResponse(data: $response);
    }
}
