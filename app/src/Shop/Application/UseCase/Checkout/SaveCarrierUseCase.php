<?php

namespace App\Shop\Application\UseCase\Checkout;

use App\Admin\Domain\Entity\Carrier;
use App\Shared\Domain\Entity\Order;
use App\Shop\Application\Service\OrderCheckoutService;

final class SaveCarrierUseCase
{
    public function __construct(private readonly OrderCheckoutService $orderManager)
    {
    }

    public function execute(Carrier $carrier, Order $order): Order
    {
        return $this->orderManager->addCarrier($order, $carrier);
    }
}
