<?php

declare (strict_types = 1);

namespace App\Admin\Country\Application\Command;

use App\Admin\Country\Application\Dto\CountryData;
use App\Admin\Domain\Entity\Country;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateCountryCommand implements CommandInterface
{
    public function __construct(
        public Country $country,
        public CountryData $countryData,
    ) {
    }
}
