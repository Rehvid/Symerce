<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Entity\CartItem;
use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Shop\Application\DTO\Response\Cart\CartSaveResponse;
use App\Shop\Application\Service\CartService;

final class RemoveCartItemUseCase
{
    public function __construct(private readonly CartService $cartManager) {}

    public function execute(Cart $cart, CartItem $cartItem): CartSaveResponse
    {
        $totalQuantityBefore = $cart->getTotalQuantity();
        $cart = $this->cartManager->deleteItem($cart, $cartItem);

        return new CartSaveResponse(totalQuantity: $totalQuantityBefore - $cart->getTotalQuantity());
    }
}
