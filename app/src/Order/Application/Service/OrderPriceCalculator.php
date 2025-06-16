<?php

declare(strict_types=1);

namespace App\Order\Application\Service;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\ValueObject\MoneyVO;
use App\Order\Application\Dto\OrderPriceSummary;

readonly class OrderPriceCalculator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
    ) {
    }

    public function calculatePriceSummary(Order $order): ?OrderPriceSummary
    {
        /** @var MoneyVO|null $productTotalPrice */
        $productTotalPrice = $this->calculateOrderItemsTotal($order);

        if (null === $productTotalPrice) {
            return null;
        }

        /** @var MoneyVO $totalPrice */
        $totalPrice = $productTotalPrice;

        $carrier = $order->getCarrier();
        if (null !== $carrier) {
            $carrierFee = $this->moneyFactory->create((string) $carrier->getFee());
            $totalPrice = $totalPrice->add($carrierFee);
        }

        $paymentMethod = $order->getPaymentMethod();
        if (null !== $paymentMethod) {
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

            if (null === $productTotalPrice) {
                $productTotalPrice = $totalPrice;
            } else {
                $productTotalPrice = $productTotalPrice->add($totalPrice);
            }
        }


        return $productTotalPrice;
    }
}
