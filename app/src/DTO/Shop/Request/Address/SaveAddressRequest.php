<?php

namespace App\DTO\Shop\Request\Address;

class SaveAddressRequest
{
    private const string DEFAULT_COUNTRY = 'PL';

    public function __construct(
        public readonly string $street,
        public readonly string $postalCode,
        public readonly string $city,
        public readonly string $country = self::DEFAULT_COUNTRY,
    ) {

    }
}
