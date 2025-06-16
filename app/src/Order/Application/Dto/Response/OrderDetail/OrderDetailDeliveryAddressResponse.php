<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailDeliveryAddressResponse
{
    public function __construct(
        public OrderDetailAddressResponse $address,
        public ?string $deliveryInstructions = null,
    ) {
    }
}
