<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Entity\OrderItem;
use App\Shared\Domain\ValueObject\Money;

final readonly class OrderPriceCalculator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
    ) {
    }

    public function calculateTotal(Order $order): ?Money
    {
        /** @var Money|null $productTotalPrice */
        $productTotalPrice = $this->calculateOrderItemsTotal($order);

        if ($productTotalPrice === null) {
            return null;
        }

        $carrier = $order->getCarrier();
        if ($carrier !== null) {
            $productTotalPrice = $productTotalPrice->add($this->moneyFactory->create($carrier->getFee()));
        }

        $paymentMethod = $order->getPaymentMethod();
        if ($paymentMethod !== null) {
            $productTotalPrice = $productTotalPrice->add($this->moneyFactory->create($paymentMethod->getFee()));
        }

        return $productTotalPrice;
    }

    public function calculateOrderItemsTotal(Order $order): ?Money
    {
        /** @var Money|null $productTotalPrice */
        $productTotalPrice = null;

        $order->getOrderItems()->map(function (OrderItem $orderItem) use (&$productTotalPrice) {
            $unitPrice = $this->moneyFactory->create($orderItem->getUnitPrice());
            $totalPrice = $unitPrice->multiply($orderItem->getQuantity());

            if ($productTotalPrice === null) {
                $productTotalPrice = $totalPrice;
            } else {
                $productTotalPrice->add($totalPrice);
            }
        });

        return $productTotalPrice;
    }
}
