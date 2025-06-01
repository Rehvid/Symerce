<?php

declare(strict_types=1);

namespace App\Order\Application\Service;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Order\Application\Dto\OrderPriceSummary;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\ValueObject\Money;

final readonly class OrderPriceCalculator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
    ) {
    }

    public function calculatePriceSummary(Order $order): ?OrderPriceSummary
    {
        /** @var Money|null $productTotalPrice */
        $productTotalPrice = $this->calculateOrderItemsTotal($order);

        if ($productTotalPrice === null) {
            return null;
        }

        /** @var Money $totalPrice */
        $totalPrice = $productTotalPrice;

        $carrier = $order->getCarrier();
        if ($carrier !== null) {
            $carrierFee = $this->moneyFactory->create($carrier->getFee());
            $totalPrice = $totalPrice->add($carrierFee);
        }

        $paymentMethod = $order->getPaymentMethod();
        if ($paymentMethod !== null) {
            $paymentMethodFee = $this->moneyFactory->create($paymentMethod->getFee());
            $totalPrice = $totalPrice->add($paymentMethodFee);
        }

        return new OrderPriceSummary(
            totalProductPrice: $productTotalPrice,
            total: $totalPrice,
            carrierFee: $carrierFee ?? null,
            paymentMethodFee: $paymentMethodFee ?? null,
        );
    }

    private function calculateOrderItemsTotal(Order $order): ?Money
    {
        /** @var Money|null $productTotalPrice */
        $productTotalPrice = null;

        /** @var OrderItem $orderItem */
        foreach ($order->getOrderItems() as $orderItem) {
            $unitPrice = $this->moneyFactory->create($orderItem->getUnitPrice());
            $totalPrice = $unitPrice->multiply($orderItem->getQuantity());

            if ($productTotalPrice === null) {
                $productTotalPrice = $totalPrice;
            } else {
                $productTotalPrice = $productTotalPrice->add($totalPrice);
            }
        }


        return $productTotalPrice;
    }
}
