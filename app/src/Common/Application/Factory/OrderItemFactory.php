<?php

declare(strict_types=1);

namespace App\Common\Application\Factory;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\OrderItem;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Service\ProductPriceCalculator;

final readonly class OrderItemFactory
{
    public function __construct(
        private ProductPriceCalculator $productPriceCalculator,
    ) {

    }

    public function create(
        int $quantity,
        Product $product,
        Order $order,
    ): OrderItem {
        $unitPrice = $this->productPriceCalculator->calculate($product, $product->getPromotionForProductTab());

        $orderItem = new OrderItem();
        $orderItem->setProduct($product);
        $orderItem->setOrder($order);
        $orderItem->setQuantity($quantity);
        $orderItem->setUnitPrice($unitPrice->getAmount());

        return $orderItem;
    }
}
