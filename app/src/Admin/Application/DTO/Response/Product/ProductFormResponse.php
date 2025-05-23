<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Product;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class ProductFormResponse extends ProductCreateFormResponse
{
    /**
     * @param array<int, mixed>|null $tags
     * @param array<int, mixed>|null $categories
     * @param array<int, mixed>|null $attributes
     * @param array<int, mixed>|null $deliveryTimes
     * @param array<int, mixed>|null $images
     */
    public function __construct(
        ?array $optionTags,
        ?array $optionCategories,
        ?array $optionVendors,
        ?array $optionDeliveryTimes,
        ?array $optionAttributes,
        ?array $promotionTypes,
        public string $name,
        public ?string $slug,
        public ?string $description,
        public string $regularPrice,
        public ?string $discountPrice,
        public int $quantity,
        public bool $isActive,
        public ?string $deliveryTime,
        public ?string $vendor,
        public ?array $tags = [],
        public ?array $categories = [],
        public ?array $attributes = [],
        public ?array $images = [],
        public ?bool $promotionIsActive = false,
        public ?string $promotionReduction = null,
        public ?string $promotionReductionType = null,
        public array $promotionDateRange = [],
        public int $stockAvailableQuantity = 0,
        public ?int $stockLowStockThreshold = null,
        public ?int $stockMaximumStockLevel = null,
        public bool $stockNotifyOnLowStock = true,
        public bool $stockVisibleInStore = true,
        public ?string $stockSku = null,
        public ?string $stockEan13 = null,
    ) {
        parent::__construct($optionTags, $optionCategories, $optionVendors, $optionDeliveryTimes, $optionAttributes, $promotionTypes);
    }
}
