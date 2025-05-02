<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\Currency\CurrencyFormResponseDTO;
use App\DTO\Response\Currency\CurrencyIndexResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\Currency;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class CurrencyResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {

    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Currency $currency) => $this->createCurrencyIndexResponse($currency), $data)
        );
    }

    private function createCurrencyIndexResponse(Currency $currency): ResponseInterfaceData
    {
        return CurrencyIndexResponseDTO::fromArray([
            'id' => $currency->getId(),
            'name' => $currency->getName(),
            'code' => $currency->getCode(),
            'symbol' => $currency->getSymbol(),
            'roundingPrecision' => $currency->getRoundingPrecision(),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Currency $currency */
        $currency = $data['entity'];

        $response = CurrencyFormResponseDTO::fromArray([
            'name' => $currency->getName(),
            'symbol' => $currency->getSymbol(),
            'code' => $currency->getCode(),
            'roundingPrecision' => $currency->getRoundingPrecision(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
