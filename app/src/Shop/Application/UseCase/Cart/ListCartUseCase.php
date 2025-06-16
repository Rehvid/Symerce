<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Cart\Application\Assembler\CartAssembler;
use App\Common\Domain\Entity\Cart;
use App\Shop\Application\DTO\Response\Cart\CartResponse;

final readonly class ListCartUseCase
{
    public function __construct(
        private CartAssembler $assembler,
    ) {
    }

    public function execute(Cart $cart): CartResponse
    {
        return $this->assembler->mapCartToResponse($cart);
    }
}
