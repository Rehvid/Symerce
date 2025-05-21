<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Shared\Domain\Entity\Cart;
use App\Shared\Domain\Entity\CartItem;
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
