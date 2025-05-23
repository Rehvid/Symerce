<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\DTO\Request\Product\SaveProductStockRequest;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductStock;

final readonly class ProductStockHydrator
{
    public function hydrate(SaveProductStockRequest $request, Product $product, ?ProductStock $productStock = null): ProductStock
    {
        $productStock = $productStock ?? new ProductStock();
        $productStock->setProduct($product);
        $productStock->setAvailableQuantity((int) $request->availableQuantity);
        $productStock->setLowStockThreshold(is_string($request->lowStockThreshold) ? (int) $request->lowStockThreshold : null);
        $productStock->setMaximumStockLevel(is_string($request->maxStockLevel) ? (int) $request->maxStockLevel : null);
        $productStock->setNotifyOnLowStock($request->notifyOnLowStock);
        $productStock->setVisibleInStore($request->visibleInStore);
        $productStock->setEan13($request->ean13);
        $productStock->setSku($request->sku);

        return $productStock;
    }
}
