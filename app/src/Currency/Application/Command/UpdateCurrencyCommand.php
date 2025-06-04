<?php

declare(strict_types=1);

namespace App\Currency\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Currency\Application\Dto\CurrencyData;

final readonly class UpdateCurrencyCommand implements CommandInterface
{
    public function __construct(
        public CurrencyData $data,
        public int $currencyId
    ) {}
}
