<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Product;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\ValueObject\Money;

final class ProductIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $name,
        public ?string $image,
        public Money $discountedPrice,
        public Money $regularPrice,
        public bool $isActive,
        public int $quantity
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            image: $data['image'],
            discountedPrice: $data['discountedPrice'],
            regularPrice: $data['regularPrice'],
            isActive: $data['isActive'],
            quantity: $data['quantity'],
        );
    }
}
