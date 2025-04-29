<?php

declare(strict_types=1);

namespace App\DTO\Request\Product;

use App\DTO\Request\PersistableInterface;

final class SaveProductRequestDTO implements PersistableInterface
{
    /**
     * @param array<int, mixed>      $categories
     * @param array<int, mixed>      $tags
     * @param array<int, mixed>      $deliveryTimes
     * @param array<int, mixed>      $images
     * @param array<int, mixed>      $attributes
     * @param array<int, mixed>|null $thumbnail
     */
    public function __construct(
        public string $name,
        public string $regularPrice,
        public string $discountPrice,
        public bool $isActive,
        public string|int $quantity,
        public array $categories = [],
        public array $tags = [],
        public array $deliveryTimes = [],
        public array $images = [],
        public array $attributes = [],
        public ?string $vendor = null,
        public ?string $slug = null,
        public ?string $description = null,
        public ?array $thumbnail = null,
    ) {
    }
}
