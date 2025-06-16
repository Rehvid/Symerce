<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Response\OrderDetail;

final readonly class OrderDetailPaymentResponse
{
    /**
     * @param OrderDetailPaymentItemResponse[] $paymentsCollection
     */
    public function __construct(
        public array $paymentsCollection,
    ) {
    }
}
