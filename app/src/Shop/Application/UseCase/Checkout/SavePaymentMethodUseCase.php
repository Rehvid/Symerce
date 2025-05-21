<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Checkout;

use App\Admin\Domain\Entity\PaymentMethod;
use App\Shared\Domain\Entity\Order;
use App\Shop\Application\Service\OrderCheckoutService;

final class SavePaymentMethodUseCase
{
    public function __construct(private readonly OrderCheckoutService $orderManager) {}

    public function execute(PaymentMethod $paymentMethod, Order $order): Order
    {
        return $this->orderManager->addPaymentMethod($order, $paymentMethod);
    }
}
