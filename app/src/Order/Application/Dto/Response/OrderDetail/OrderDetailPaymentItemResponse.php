<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailPaymentItemResponse
{
    public function __construct(
        public int $id,
        public string $paymentStatus,
        public ?string $paidAt,
        public ?string $amount = null,
        public ?string $gatewayTransactionId = null,
        public ?string $paymentMethodName = null,
    ) {
    }
}
