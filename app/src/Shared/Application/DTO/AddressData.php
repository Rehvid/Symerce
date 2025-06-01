<?php

declare(strict_types = 1);

namespace App\Shared\Application\DTO;

use App\Common\Domain\Entity\Country;

final readonly class AddressData
{
    public function __construct(
        public string $street,
        public string $postalCode,
        public string $city,
        public ?Country $country,
    ) {}
}
