<?php

declare(strict_types=1);

namespace App\Shared\Application\Factory;

use App\Admin\Domain\Entity\Product;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Entity\OrderItem;
use App\Shared\Domain\Service\ProductPriceCalculator;

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
