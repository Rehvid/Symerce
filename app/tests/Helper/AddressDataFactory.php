<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Application\Dto\AddressData;
use App\Common\Domain\Entity\Country;

final class AddressDataFactory
{
    public static function valid(): AddressData
    {
        return new AddressData(
            street: '123 Main St',
            postalCode: '12-345',
            city: 'Sample City',
            country: CountryFactory::poland()
        );
    }

    public static function withCustomData(
        string $street,
        string $postalCode,
        string $city,
        ?Country $country
    ): AddressData {
        return new AddressData(
            street: $street,
            postalCode: $postalCode,
            city: $city,
            country: $country
        );
    }

    public static function empty(): AddressData
    {
        return new AddressData(
            street: '',
            postalCode: '',
            city: '',
            country: null
        );
    }
}
