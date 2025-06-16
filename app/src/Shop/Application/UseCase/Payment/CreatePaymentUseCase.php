<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Payment;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\Payment;
use App\Common\Domain\Entity\PaymentMethod;
use App\Order\Domain\Enums\PaymentStatus;

final readonly class CreatePaymentUseCase
{
    public function execute(Order $order, PaymentMethod $paymentMethod): Payment
    {
        $payment = new Payment();
        $payment->setOrder($order);
        $payment->setPaymentMethod($paymentMethod);
        $payment->setAmount($order->getTotalPrice());

        if (!$paymentMethod->isRequiresWebhook()) {
            $payment->setStatus(PaymentStatus::PENDING);
        }

        return $payment;
    }
}
