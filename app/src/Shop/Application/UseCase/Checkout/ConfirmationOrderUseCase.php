<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\Entity\Order;
use App\Manager\OrderManager;

final class ConfirmationOrderUseCase
{
    public function __construct(
        private readonly OrderManager $orderManager,
    )
    {
    }

    public function execute(Order $order): void
    {
        $this->orderManager->confirmationOrder($order);
    }
}
