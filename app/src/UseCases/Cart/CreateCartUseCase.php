<?php

declare(strict_types=1);

namespace App\UseCases\Cart;

use App\DTO\Shop\Request\Cart\SaveCartRequest;
use App\Entity\Cart;
use App\Manager\CartManager;

final class CreateCartUseCase
{
    public function __construct(private readonly CartManager $cartManager)
    {
    }

    public function execute(SaveCartRequest $request): Cart
    {
        return $this->cartManager->create($request);
    }
}
