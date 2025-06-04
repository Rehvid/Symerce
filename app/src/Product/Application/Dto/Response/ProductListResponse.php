<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response;

use App\Common\Domain\ValueObject\MoneyVO;

final readonly class ProductListResponse
{
    public function __construct(
        public int      $id,
        public string   $name,
        public ?string  $image,
        public ?MoneyVO $discountedPrice,
        public MoneyVO  $regularPrice,
        public bool     $isActive,
        public int      $quantity,
        public string   $showUrl
    ) {
    }
}
