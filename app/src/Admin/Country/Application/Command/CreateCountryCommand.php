<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Command;

use App\Admin\Country\Application\Dto\CountryData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreateCountryCommand implements CommandInterface
{
    public function __construct(
        public CountryData $countryData,
    ) {}
}
