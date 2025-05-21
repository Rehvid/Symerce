<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\Shared\Domain\Entity\Order;
use App\Shop\Application\Service\OrderCheckoutService;

final class ConfirmationOrderUseCase
{
    public function __construct(
        private readonly OrderCheckoutService $orderManager,
    )
    {
    }

    public function execute(Order $order): void
    {
        $this->orderManager->confirmationOrder($order);
    }
}
