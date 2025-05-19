<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\DTO\Shop\Request\Cart\ChangeQuantityProductRequest;
use App\DTO\Shop\Response\Cart\CartSaveResponseDTO;
use App\Entity\Cart;
use App\Manager\CartManager;

final class ChangeProductQuantityUseCase
{
    public function __construct(
        private readonly CartManager $cartManager,
    )
    {
    }

    public function execute(Cart $cart, ChangeQuantityProductRequest $changeQuantityProductRequest ): ResponseInterfaceData
    {
        $quantityDiff = $this->cartManager->changeQuantityCartItem($changeQuantityProductRequest, $cart);

        return CartSaveResponseDTO::fromArray([
            'totalQuantity' => $quantityDiff
        ]);
    }
}
