<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Product;

use App\DTO\Admin\Response\ResponseInterfaceData;

final class ProductUpdateFormResponseDTO extends ProductFormResponseDTO
{
    /**
     * @param array<int, mixed>|null $tags
     * @param array<int, mixed>|null $categories
     * @param array<int, mixed>|null $attributes
     * @param array<int, mixed>|null $deliveryTimes
     * @param array<int, mixed>|null $images
     */
    protected function __construct(
        ?array $optionTags,
        ?array $optionCategories,
        ?array $optionVendors,
        ?array $optionDeliveryTimes,
        ?array $optionAttributes,
        public string $name,
        public ?string $slug,
        public ?string $description,
        public string $regularPrice,
        public ?string $discountPrice,
        public int $quantity,
        public bool $isActive,
        public ?string $vendor,
        public ?array $tags = [],
        public ?array $categories = [],
        public ?array $attributes = [],
        public ?array $deliveryTimes = [],
        public ?array $images = []
    ) {
        parent::__construct($optionTags, $optionCategories, $optionVendors, $optionDeliveryTimes, $optionAttributes);
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            optionTags: $data['optionTags'],
            optionCategories: $data['optionCategories'],
            optionVendors: $data['optionVendors'],
            optionDeliveryTimes: $data['optionDeliveryTimes'],
            optionAttributes: $data['optionAttributes'],
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'],
            regularPrice: $data['regularPrice'],
            discountPrice: $data['discountPrice'],
            quantity: $data['quantity'],
            isActive: $data['isActive'],
            vendor: $data['vendor'] ?? null,
            tags: $data['tags'],
            categories: $data['categories'] ?? [],
            attributes: $data['attributes'] ?? [],
            deliveryTimes: $data['deliveryTimes'],
            images: $data['images'] ?? [],
        );
    }
}
