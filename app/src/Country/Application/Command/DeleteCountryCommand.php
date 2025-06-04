<?php

declare(strict_types=1);

namespace App\Country\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteCountryCommand implements CommandInterface
{
    public function __construct(
        public int $countryId,
    ) {}
}
