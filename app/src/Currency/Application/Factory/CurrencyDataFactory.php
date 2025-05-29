<?php

declare(strict_types=1);

namespace App\Currency\Application\Factory;

use App\Currency\Application\Dto\CurrencyData;
use App\Currency\Application\Dto\Request\SaveCurrencyRequest;

final readonly class CurrencyDataFactory
{
    public function fromRequest(SaveCurrencyRequest $currencyRequest): CurrencyData
    {
        return new CurrencyData(
            code: $currencyRequest->code,
            name: $currencyRequest->name,
            symbol: $currencyRequest->symbol,
            roundingPrecision: (int) $currencyRequest->roundingPrecision,
        );
    }
}
