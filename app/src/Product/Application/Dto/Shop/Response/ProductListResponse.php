<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Shop\Response;

final readonly class ProductListResponse
{
    public function __construct(
        public string $name,
        public string $url,
        public ?string $thumbnail,
        public ?string $discountPrice,
        public string $regularPrice,
        public bool $hasPromotion
    ) {
    }
}
