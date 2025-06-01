<?php

declare(strict_types=1);

namespace App\Country\Application\Factory;

use App\Country\Application\Dto\CountryData;
use App\Country\Application\Dto\Request\SaveCountryRequest;

final readonly class CountryDataFactory
{
    public function fromRequest(SaveCountryRequest $request): CountryData
    {
        return new CountryData(
            code: $request->code,
            name: $request->name,
            isActive: $request->isActive,
        );
    }
}
