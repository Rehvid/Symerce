<?php

declare(strict_types=1);

namespace App\Currency\Application\Command;

use App\Currency\Application\Dto\CurrencyData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateCurrencyCommand implements CommandInterface
{
    public function __construct(
        public CurrencyData $data,
        public int $currencyId
    ) {}
}
