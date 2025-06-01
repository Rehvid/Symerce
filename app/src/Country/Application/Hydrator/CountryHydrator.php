<?php

declare(strict_types=1);

namespace App\Country\Application\Hydrator;

use App\Admin\Domain\Entity\Country;
use App\Country\Application\Dto\CountryData;

final readonly class CountryHydrator
{
    public function hydrate(CountryData $countryData, ?Country $country = null): Country
    {
        $country ??= new Country();
        $country->setCode($countryData->code);
        $country->setName($countryData->name);
        $country->setActive($countryData->isActive);

        return $country;
    }
}
