<?php

declare (strict_types = 1);

namespace App\Country\Application\Command;

use App\Admin\Domain\Entity\Country;
use App\Country\Application\Dto\CountryData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateCountryCommand implements CommandInterface
{
    public function __construct(
        public Country $country,
        public CountryData $countryData,
    ) {
    }
}
