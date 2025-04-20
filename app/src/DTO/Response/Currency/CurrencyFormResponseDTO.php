<?php

declare(strict_types=1);

namespace App\DTO\Response\Currency;

use App\DTO\Response\ResponseInterfaceData;

final readonly class CurrencyFormResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $name,
        public string $symbol,
        public string $code,
        public int $roundingPrecision
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            name: $data['name'],
            symbol: $data['symbol'],
            code: $data['code'],
            roundingPrecision: $data['roundingPrecision']
        );
    }
}
