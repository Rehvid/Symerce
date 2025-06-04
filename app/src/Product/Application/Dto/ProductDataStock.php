<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Admin\Domain\ValueObject\DateVO;
use App\Common\Domain\Entity\ProductStock;
use App\Common\Domain\Entity\Warehouse;

final readonly class ProductDataStock
{
    public function __construct(
        public ?ProductStock $productStock,
        public int $availableQuantity,
        public Warehouse $warehouse,
        public ?int $ean13,
        public ?int $sku,
        public ?int $lowStockThreshold,
        public ?int $maximumStockLevel,
        public ?DateVO $restockDate
    ) {}
}
