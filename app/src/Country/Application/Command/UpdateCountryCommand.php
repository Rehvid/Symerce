<?php

declare (strict_types = 1);

namespace App\Country\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Country\Application\Dto\CountryData;

final readonly class UpdateCountryCommand implements CommandInterface
{
    public function __construct(
        public int $countryId,
        public CountryData $data,
    ) {
    }
}
