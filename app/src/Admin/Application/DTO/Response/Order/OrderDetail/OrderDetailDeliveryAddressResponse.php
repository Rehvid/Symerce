<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailDeliveryAddressResponse
{
    public function __construct(
        public OrderDetailAddressResponse $address,
        public ?string $deliveryInstructions = null,
    ) {}
}
