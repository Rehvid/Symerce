<?php

declare(strict_types=1);

namespace App\UseCases\Cart;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\DTO\Shop\Request\Cart\SaveCartRequest;
use App\DTO\Shop\Response\Cart\CartSaveResponseDTO;
use App\Entity\Cart;
use App\Manager\CartManager;

final class UpdateCartUseCase
{
    public function __construct(private readonly CartManager $cartManager)
    {
    }

    public function execute(SaveCartRequest $request, Cart $cart): ResponseInterfaceData
    {
        $totalQuantityBefore = $cart->getTotalQuantity();

        $cart = $this->cartManager->update($request, $cart);

        return CartSaveResponseDTO::fromArray([
            'totalQuantity' => abs($totalQuantityBefore - $cart->getTotalQuantity()),
        ]);
    }
}
