<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Currency;

final readonly class CurrencyListResponse
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public string $symbol,
        public int $roundingPrecision
    ) {
    }
}
