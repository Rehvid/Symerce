<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Response;

use App\Admin\Domain\Entity\Country;

final readonly class CustomerFormResponse
{
    public function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public string $phone,
        public bool $isActive,
        public bool $isDelivery,
        public bool $isInvoice,
        public ?string $street,
        public ?string $postalCode,
        public ?string $city,
        public ?string $deliveryInstructions,
        public ?int $country,
        public ?string $invoiceStreet,
        public ?string $invoicePostalCode,
        public ?string $invoiceCity,
        public ?string $invoiceCompanyName,
        public ?string $invoiceCompanyTaxId,
        public ?int $invoiceCountry,
    ){

    }
}
