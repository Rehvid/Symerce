<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\DTO\Shop\Request\Checkout\SaveCheckoutAddressRequest;
use App\Entity\Cart;
use App\Entity\Order;
use App\Manager\OrderManager;


class SaveCheckoutAddressUseCase
{
    public function __construct(
        private readonly OrderManager $orderManager,
    ) {}

    public function execute(SaveCheckoutAddressRequest $request, Cart $cart, ?Order $order): Order
    {
        if (null === $order) {
            return $this->orderManager->createOrder($request, $cart);
        }

        return $this->orderManager->updateAddresses($request, $order);
    }
}
