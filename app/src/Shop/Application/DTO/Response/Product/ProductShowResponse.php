<?php

declare(strict_types=1);

namespace App\Shop\Application\DTO\Response\Product;

use App\Admin\Domain\Entity\Vendor;
use Doctrine\Common\Collections\Collection;

final readonly class ProductShowResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public ?Vendor $vendor,
        public string $description,
        public string $regularPrice,
        public ?string $discountPrice,
        public int $quantity,
        public bool $isOutOfStock,
        public bool $hasPromotion,
        public int $refund,
        public string $deliveryTime,
        public string $deliveryFee,
        public array $attributes,
        public array $tags,
        public ?string $thumbnail,
        public array|Collection $images,
    ) {

    }
}
