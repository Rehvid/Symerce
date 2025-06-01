<?php

declare(strict_types = 1);

namespace App\Currency\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class GetCurrencyForEditQuery implements QueryInterface
{
    public function __construct(
        public int $currencyId
    ) {

    }
}
