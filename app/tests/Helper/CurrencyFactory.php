<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Domain\Entity\Currency;

final class CurrencyFactory
{
    public static function valid(): Currency
    {
        return self::custom(
            name: "Polski złoty",
            code: "PLN",
            symbol: "zł",
            roundingPrecision: 2
        );
    }

    public static function custom(string $name, string $code, string $symbol, int $roundingPrecision): Currency
    {
        $currency = new Currency();
        $currency->setName($name);
        $currency->setCode($code);
        $currency->setSymbol($symbol);
        $currency->setRoundingPrecision($roundingPrecision);

        return $currency;
    }
}
