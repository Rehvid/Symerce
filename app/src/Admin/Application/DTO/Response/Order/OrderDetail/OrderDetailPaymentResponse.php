<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Order\OrderDetail;

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
