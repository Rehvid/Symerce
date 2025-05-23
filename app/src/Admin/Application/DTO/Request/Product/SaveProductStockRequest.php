<?php

declare( strict_types = 1 );

namespace App\Admin\Application\DTO\Request\Product;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveProductStockRequest
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] public string|int $availableQuantity,
        public string|int|null $lowStockThreshold = null,
        public string|int|null $maxStockLevel = null,
        public bool $notifyOnLowStock = false,
        public bool $visibleInStore = false,
        public ?int $ean13 = null,
        public ?int $sku = null,
    ) {
    }
}
