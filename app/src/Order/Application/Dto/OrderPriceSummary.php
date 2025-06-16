<?php

declare(strict_types=1);

namespace App\Order\Application\Dto;

use App\Common\Domain\ValueObject\MoneyVO;

final readonly class OrderPriceSummary
{
    public function __construct(
        public ?MoneyVO $totalProductPrice,
        public MoneyVO $total,
        public ?MoneyVO $carrierFee,
        public ?MoneyVO $paymentMethodFee
    ) {

    }
}
