<?php

declare(strict_types=1);

namespace App\Currency\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteCurrencyCommand implements CommandInterface
{
    public function __construct(
        public int $currencyId,
    ) {}
}
