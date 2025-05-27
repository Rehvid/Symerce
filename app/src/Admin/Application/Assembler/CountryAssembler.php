<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Country\CountryFormResponse;
use App\Admin\Application\DTO\Response\Country\CountryListResponse;
use App\Admin\Domain\Entity\Country;

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
            name: $country->getName(),
            code: $country->getCode(),
            isActive: $country->isActive(),
        );

        return $this->responseHelperAssembler->wrapFormResponse(data: $response);
    }
}
