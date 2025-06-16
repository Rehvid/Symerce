<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Common\Domain\Entity\Cart;
use App\Shop\Application\DTO\Request\Cart\SaveCartRequest;
use App\Shop\Application\DTO\Response\Cart\CartSaveResponse;
use App\Shop\Application\Service\CartService;

final class UpdateCartUseCase
{
    public function __construct(private readonly CartService $cartManager)
    {
    }

    public function execute(SaveCartRequest $request, Cart $cart): CartSaveResponse
    {
        $totalQuantityBefore = $cart->getTotalQuantity();

        $cart = $this->cartManager->update($request, $cart);

        return new CartSaveResponse(
            totalQuantity: abs($totalQuantityBefore - $cart->getTotalQuantity())
        );
    }
}
