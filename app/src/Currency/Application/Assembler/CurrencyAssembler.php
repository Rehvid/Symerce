<?php

declare (strict_types = 1);

namespace App\Currency\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Domain\Entity\Currency;
use App\Currency\Application\Dto\Response\CurrencyFormResponse;
use App\Currency\Application\Dto\Response\CurrencyListResponse;

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
        $dataList = array_map(
            fn (Currency $currency) => $this->createCurrencyListResponse($currency),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($dataList);
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Currency $currency): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
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
