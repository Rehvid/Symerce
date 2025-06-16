<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response\Form;

final readonly class ProductFormContext
{
    public function __construct(
        public ?array $availableTags,
        public ?array $availableCategories,
        public ?array $availableBrands,
        public ?array $availablePromotionTypes,
        public ?array $availableWarehouses,
        public ?array $availableAttributes = [],
    ) {
    }
}
