<?php

declare(strict_types=1);

namespace App\Currency\Application\Dto;

final readonly class CurrencyData
{
    public function __construct(
        public string $code,
        public string $name,
        public string $symbol,
        public int $roundingPrecision,
    ) {
    }
}
