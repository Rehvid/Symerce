<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order;

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
        public ?string $deliveryInstructions,
        public ?string $invoiceStreet,
        public ?string $invoiceCity,
        public ?string $invoicePostalCode,
        public ?string $companyName,
        public ?string $companyTaxId,
        public array $products,
    ) {}
}
