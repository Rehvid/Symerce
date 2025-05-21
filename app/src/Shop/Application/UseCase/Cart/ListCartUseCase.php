<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Entity\Cart;
use App\Mapper\Shop\CartMapper;
use App\Shop\Application\DTO\Response\Cart\CartResponse;

final class ListCartUseCase
{
    public function __construct(
        private readonly CartMapper $cartMapper
    ) {
    }

    public function execute(Cart $cart): CartResponse
    {
        return $this->cartMapper->mapCartToResponse($cart);
    }
}
