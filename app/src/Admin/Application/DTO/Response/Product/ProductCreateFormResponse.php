<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Product;


readonly class ProductCreateFormResponse
{
    /**
     * @param array<int, mixed> $optionTags
     * @param array<int, mixed> $optionCategories
     * @param array<int, mixed> $optionVendors
     * @param array<int, mixed> $optionDeliveryTimes
     * @param array<int, mixed> $optionAttributes
     */
    public function __construct(
        public ?array $optionTags,
        public ?array $optionCategories,
        public ?array $optionVendors,
        public ?array $optionDeliveryTimes,
        public ?array $optionAttributes,
        public ?array $promotionTypes
    ) {
    }
}
