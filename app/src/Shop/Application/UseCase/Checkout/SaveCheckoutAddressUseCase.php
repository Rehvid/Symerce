<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\Shared\Domain\Entity\Cart;
use App\Shared\Domain\Entity\Order;
use App\Shop\Application\DTO\Request\Checkout\SaveCheckoutAddressRequest;
use App\Shop\Application\Service\OrderCheckoutService;


class SaveCheckoutAddressUseCase
{
    public function __construct(
        private readonly OrderCheckoutService $orderManager,
    ) {}

    public function execute(SaveCheckoutAddressRequest $request, Cart $cart, ?Order $order): Order
    {
        if (null === $order) {
            return $this->orderManager->createOrder($request, $cart);
        }

        return $this->orderManager->updateAddresses($request, $order);
    }
}
