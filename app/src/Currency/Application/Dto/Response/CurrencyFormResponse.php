<?php

declare(strict_types=1);

namespace App\Currency\Application\Dto\Response;

final readonly class CurrencyFormResponse
{
    public function __construct(
        public string $name,
        public string $symbol,
        public string $code,
        public int $roundingPrecision
    ) {
    }
}
