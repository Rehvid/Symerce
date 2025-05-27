<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

final readonly class OrderDetailSummaryResponse
{
    public function __construct(
        public ?string $summaryProductPrice,
        public ?string $deliveryFee,
        public ?string $paymentMethodFee,
        public ?string $totalPrice
    ) {
    }
}
