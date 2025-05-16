<?php

declare(strict_types=1);

namespace App\DTO\Shop\Request\Address;

class SaveAddressInvoiceRequest extends SaveAddressRequest
{

    public function __construct(
        string $street,
        string $postalCode,
        string $city,
        public readonly ?string $companyName = null,
        public readonly ?string $companyTaxId = null,
    ) {
        parent::__construct($street, $postalCode, $city);
    }
}
