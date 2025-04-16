<?php

namespace App\DTO\Response\Currency;

use App\DTO\Response\ResponseInterfaceData;

class CurrencyIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $symbol,
        public int $roundingPrecision
    ){

    }


    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            code: $data['code'],
            name: $data['name'],
            symbol: $data['symbol'],
            roundingPrecision: $data['roundingPrecision']
        );
    }
}
