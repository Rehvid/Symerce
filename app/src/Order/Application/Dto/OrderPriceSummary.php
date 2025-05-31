<?php

declare(strict_types=1);

namespace App\Order\Application\Dto;

use App\Shared\Domain\ValueObject\Money;

final readonly class OrderPriceSummary
{
    public function __construct(
        public ?Money $totalProductPrice,
        public Money $total,
        public ?Money $carrierFee,
        public ?Money $paymentMethodFee
    ) {

    }
}
