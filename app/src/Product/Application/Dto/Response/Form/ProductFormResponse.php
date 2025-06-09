<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response\Form;

use App\Common\Application\Dto\OptionItem;

final readonly class ProductFormResponse
{

    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public ?string $description,
        public string $regularPrice,
        public bool $isActive,
        public int $mainCategory,
        public ?int $brand,
        public ?array $stocks,
        public ?array $tags = [],
        public ?array $categories = [],
        public ?array $attributes = [],
        public ?array $images = [],
        public ?bool $promotionIsActive = false,
        public ?string $promotionReduction = null,
        public ?string $promotionReductionType = null,
        public array $promotionDateRange = [],

    ) {
    }
}
