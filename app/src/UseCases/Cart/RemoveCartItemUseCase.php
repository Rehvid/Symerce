<?php

declare(strict_types=1);

namespace App\UseCases\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\DTO\Shop\Response\Cart\CartSaveResponseDTO;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Manager\CartManager;

final class RemoveCartItemUseCase
{
    public function __construct(private readonly CartManager $cartManager) {}

    public function execute(Cart $cart, CartItem $cartItem): ResponseInterfaceData
    {
        $totalQuantityBefore = $cart->getTotalQuantity();
        $cart = $this->cartManager->deleteItem($cart, $cartItem);

        return CartSaveResponseDTO::fromArray([
            'totalQuantity' => $totalQuantityBefore - $cart->getTotalQuantity(),
        ]);
    }
}
