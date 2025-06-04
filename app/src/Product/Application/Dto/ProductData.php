<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Tag;

final readonly class ProductData
{
    /**
     * @param ProductImageData[] $images,
     * @param ProductAttributeData[] $attributes
     * @param ProductDataStock[] $stocks
     * @param Tag[] $tags
     * @param Category[] $categories
     */
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $description,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public ?string $regularPrice,
        public bool $isActive,
        public Category $mainCategory,
        public Brand $brand,
        public ?ProductPromotionData $promotionData,
        public array $stocks,
        public array $images,
        public array $attributes,
        public array $tags,
        public array $categories,
    ){}
}
