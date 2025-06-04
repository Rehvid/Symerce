<?php

declare(strict_types=1);

namespace App\Cart\Application\Handler;

use App\Cart\Application\Assembler\CartAssembler;
use App\Cart\Application\Query\GetCartDetailQuery;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CartDetailQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CartRepositoryInterface $repository,
        private CartAssembler $assembler
    ) {}

    public function __invoke(GetCartDetailQuery $query): array
    {
        /** @var ?Cart $cart */
        $cart = $this->repository->findById($query->cartId);
        if (null === $cart) {
            throw EntityNotFoundException::for(Cart::class, $query->cartId);
        }

        return $this->assembler->toDetailResponse($cart);
    }
}
