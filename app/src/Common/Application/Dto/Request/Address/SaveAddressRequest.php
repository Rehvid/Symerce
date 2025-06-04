<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request\Address;

final readonly class SaveAddressRequest
{

    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public int $country
    ) {

    }
}
