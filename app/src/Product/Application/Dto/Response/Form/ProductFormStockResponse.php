<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response\Form;

use App\Common\Application\Dto\OptionItem;
use DateTimeInterface;

final readonly class ProductFormStockResponse
{
    public function __construct(
        public int $availableQuantity,
        public ?string $ean13,
        public ?string $sku,
        public ?int $lowStockThreshold,
        public ?int $maximumStockLevel,
        public ?OptionItem $warehouseId,
        public ?DateTimeInterface $restockDate,
    ) {}
}
