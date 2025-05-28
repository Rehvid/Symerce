<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Hydrator;

use App\Admin\Country\Application\Dto\CountryData;
use App\Admin\Domain\Entity\Country;

final readonly class CountryHydrator
{
    public function hydrate(CountryData $countryData, Country $country): Country
    {
        $country->setCode($countryData->code);
        $country->setName($countryData->name);
        $country->setActive($countryData->isActive);

        return $country;
    }
}
