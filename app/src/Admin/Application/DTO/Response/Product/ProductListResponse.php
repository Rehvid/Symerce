<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Product;

use App\Shared\Domain\ValueObject\Money;

final readonly class ProductListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $image,
        public ?Money $discountedPrice,
        public Money $regularPrice,
        public bool $isActive,
        public int $quantity,
        public string $showUrl
    ) {
    }
}
