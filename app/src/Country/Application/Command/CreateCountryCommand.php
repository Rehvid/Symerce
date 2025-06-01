<?php

declare(strict_types=1);

namespace App\Country\Application\Command;

use App\Country\Application\Dto\CountryData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreateCountryCommand implements CommandInterface
{
    public function __construct(
        public CountryData $data,
    ) {}
}
