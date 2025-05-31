<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

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
