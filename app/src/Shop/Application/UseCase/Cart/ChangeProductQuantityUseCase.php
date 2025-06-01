<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Common\Domain\Entity\Cart;
use App\Shop\Application\DTO\Request\Cart\ChangeQuantityProductRequest;
use App\Shop\Application\DTO\Response\Cart\CartSaveResponse;
use App\Shop\Application\Service\CartService;

final readonly class ChangeProductQuantityUseCase
{
    public function __construct(
        private CartService $cartManager,
    ) {
    }

    public function execute(Cart $cart, ChangeQuantityProductRequest $changeQuantityProductRequest ): CartSaveResponse
    {
        $quantityDiff = $this->cartManager->changeQuantityCartItem($changeQuantityProductRequest, $cart);

        return new CartSaveResponse(totalQuantity: $quantityDiff);
    }
}
