<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Request\Address;

final readonly class SaveAddressRequest
{
    private const string DEFAULT_COUNTRY = 'PL';

    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public string $country = self::DEFAULT_COUNTRY,
    ) {

    }
}
