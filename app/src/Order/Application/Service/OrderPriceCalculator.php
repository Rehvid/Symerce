<?php

declare(strict_types=1);

namespace App\Order\Application\Service;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\ValueObject\MoneyVO;
use App\Order\Application\Dto\OrderPriceSummary;

final readonly class OrderPriceCalculator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
    ) {
    }

    public function calculatePriceSummary(Order $order): ?OrderPriceSummary
    {
        /** @var MoneyVO|null $productTotalPrice */
        $productTotalPrice = $this->calculateOrderItemsTotal($order);

        if ($productTotalPrice === null) {
            return null;
        }

        /** @var MoneyVO $totalPrice */
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

    private function calculateOrderItemsTotal(Order $order): ?MoneyVO
    {
        /** @var MoneyVO|null $productTotalPrice */
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
