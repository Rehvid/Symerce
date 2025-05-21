<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart;

use App\Entity\Cart;
use App\Shop\Application\DTO\Request\Cart\SaveCartRequest;
use App\Shop\Application\Service\CartService;

final class CreateCartUseCase
{
    public function __construct(private readonly CartService $cartManager)
    {
    }

    public function execute(SaveCartRequest $request): Cart
    {
        return $this->cartManager->create($request);
    }
}
