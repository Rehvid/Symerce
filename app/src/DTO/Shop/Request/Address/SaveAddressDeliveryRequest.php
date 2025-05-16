<?php

declare(strict_types=1);

namespace App\DTO\Shop\Request\Address;

class SaveAddressDeliveryRequest extends SaveAddressRequest
{
    public function __construct(
        string $street,
        string $postalCode,
        string $city,
        public ?string $deliveryInstructions = null,
    ) {
        parent::__construct($street, $postalCode, $city);
    }
}
