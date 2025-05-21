<?php

declare (strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Currency\SaveCurrencyRequest;
use App\Admin\Domain\Entity\Currency;

final readonly class CurrencyHydrator
{
    public function hydrate(SaveCurrencyRequest $request, Currency $currency) : Currency
    {
        $currency->setName($request->name);
        $currency->setSymbol($request->symbol);
        $currency->setRoundingPrecision((int) $request->roundingPrecision);
        $currency->setCode($request->code);

        return $currency;
    }
}
