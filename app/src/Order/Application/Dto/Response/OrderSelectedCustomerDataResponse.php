<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response;

final readonly class OrderSelectedCustomerDataResponse
{
    public function __construct(
        public string $email,
        public string $firstname,
        public string $surname,
        public string $phone,
        public string $postalCode,
        public string $street,
        public string $city,
        public int $countryId,
        public string $deliveryInstructions,
        public bool $isInvoice,
        public string $invoiceStreet,
        public string $invoiceCompanyName,
        public string $invoicePostalCode,
        public string $invoiceCompanyTaxId,
        public int $invoiceCountryId,
        public string $invoiceCity,
    ) {

    }
}
