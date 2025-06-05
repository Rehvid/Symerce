<?php

declare (strict_types=1);

namespace App\Currency\Application\Hydrator;

use App\Common\Domain\Entity\Currency;
use App\Currency\Application\Dto\CurrencyData;

final readonly class CurrencyHydrator
{
    public function hydrate(CurrencyData $data, Currency $currency) : Currency
    {
        $currency->setName($data->name);
        $currency->setSymbol($data->symbol);
        $currency->setRoundingPrecision($data->roundingPrecision);
        $currency->setCode($data->code);

        return $currency;
    }
}
