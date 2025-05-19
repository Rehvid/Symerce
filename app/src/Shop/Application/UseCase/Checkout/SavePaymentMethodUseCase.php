<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\Entity\Order;
use App\Entity\PaymentMethod;
use App\Manager\OrderManager;

final class SavePaymentMethodUseCase
{
    public function __construct(private readonly OrderManager $orderManager) {}

    public function execute(PaymentMethod $paymentMethod, Order $order): Order
    {
        return $this->orderManager->addPaymentMethod($order, $paymentMethod);
    }
}
