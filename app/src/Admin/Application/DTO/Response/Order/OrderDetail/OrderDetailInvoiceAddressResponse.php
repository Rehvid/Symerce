<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailInvoiceAddressResponse
{
    public function __construct(
        public OrderDetailAddressResponse $address,
        public ?string $companyTaxId = null,
        public ?string $companyName = null,
    ) {}
}
