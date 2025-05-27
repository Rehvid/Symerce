<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailAddressResponse
{
    public function __construct(
        public string $street,
        public string $city,
        public string $postalCode,
        public string $country,
    ) {}
}
