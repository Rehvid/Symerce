<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Application\DTO\Request\Product\SaveProductStockRequest;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductStock;

final readonly class ProductStockHydrator
{
    public function hydrate(SaveProductStockRequest $request, Product $product, ?ProductStock $productStock = null): ProductStock
    {

        $productStock = $productStock ?? new ProductStock();
        $productStock->setProduct($product);
        $productStock->setAvailableQuantity((int) $request->availableQuantity);
        $productStock->setLowStockThreshold(!$request->lowStockThreshold ? null : (int) $request->lowStockThreshold);
        $productStock->setMaximumStockLevel(!$request->maxStockLevel ? null : (int) $request->maxStockLevel);
        $productStock->setNotifyOnLowStock($request->notifyOnLowStock);
        $productStock->setVisibleInStore($request->visibleInStore);
        $productStock->setEan13($request->ean13);
        $productStock->setSku($request->sku);

        return $productStock;
    }
}
