<?php

declare (strict_types = 1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Currency\CurrencyFormResponse;
use App\Admin\Application\DTO\Response\Currency\CurrencyListResponse;
use App\Admin\Domain\Entity\Currency;

final readonly class CurrencyAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {

    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $categoryListCollection = array_map(
            fn (Currency $currency) => $this->createCurrencyListResponse($currency),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($categoryListCollection);
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Currency $currency): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new CurrencyFormResponse(
                name: $currency->getName(),
                symbol: $currency->getSymbol(),
                code: $currency->getCode(),
                roundingPrecision: $currency->getRoundingPrecision(),
            )
        );
    }

    private function createCurrencyListResponse(Currency $currency): CurrencyListResponse
    {
        return new CurrencyListResponse(
            id: $currency->getId(),
            code: $currency->getCode(),
            name: $currency->getName(),
            symbol: $currency->getSymbol(),
            roundingPrecision: $currency->getRoundingPrecision(),
        );
    }
}
