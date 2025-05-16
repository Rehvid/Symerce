<?php

namespace App\UseCases\Checkout;

use App\Entity\Carrier;
use App\Entity\Order;
use App\Manager\OrderManager;

final class SaveCarrierUseCase
{
    public function __construct(private readonly OrderManager $orderManager)
    {
    }

    public function execute(Carrier $carrier, Order $order): Order
    {
        return $this->orderManager->addCarrier($order, $carrier);
    }
}
