<?php

declare(strict_types=1);

namespace App\DTO\Shop\Response\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class CartSaveResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $totalQuantity,
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            totalQuantity: $data['totalQuantity'],
        );
    }
}
