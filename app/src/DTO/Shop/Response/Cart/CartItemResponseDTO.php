<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class CartItemResponseDTO implements ResponseInterfaceData
{
    public function __construct(
        public readonly string $id,
    )
    {
    }


    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
        );
    }
}
