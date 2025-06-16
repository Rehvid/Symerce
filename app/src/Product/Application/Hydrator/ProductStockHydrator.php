<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductStock;
use App\Product\Application\Dto\ProductDataStock;

final readonly class ProductStockHydrator
{
    public function hydrate(ProductDataStock $data, Product $product, ProductStock $productStock): ProductStock
    {
        $productStock->setProduct($product);
        $productStock->setAvailableQuantity($data->availableQuantity);
        $productStock->setLowStockThreshold($data->lowStockThreshold);
        $productStock->setMaximumStockLevel($data->maximumStockLevel);
        $productStock->setEan13((string) $data->ean13);
        $productStock->setSku((string) $data->sku);
        $productStock->setWarehouse($data->warehouse);

        $restockDate = $data->restockDate?->get();
        if ($restockDate) {
            $productStock->setRestockDate(\DateTimeImmutable::createFromInterface($restockDate));
        } else {
            $productStock->setRestockDate(new \DateTime());
        }


        return $productStock;
    }
}
