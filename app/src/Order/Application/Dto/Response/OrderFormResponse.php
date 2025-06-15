<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response;

final readonly class OrderFormResponse
{
    public function __construct(
        public string $checkoutStep,
        public string $status,
        public string $uuid,
        public ?int $carrierId,
        public ?int $paymentMethodId,
        public bool $isInvoice,
        public ?string $firstname,
        public ?string $surname,
        public ?string $email,
        public ?string $phone,
        public ?string $postalCode,
        public ?string $city,
        public ?string $street,
        public ?int $countryId,
        public ?string $deliveryInstructions,
        public ?string $invoiceStreet,
        public ?string $invoiceCity,
        public ?string $invoicePostalCode,
        public ?int $invoiceCountryId,
        public ?string $invoiceCompanyName,
        public ?string $invoiceCompanyTaxId,
        public ?int $customerId,
        public array $products,
    ) {}
}
