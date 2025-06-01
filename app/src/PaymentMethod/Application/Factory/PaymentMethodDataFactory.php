<?php

declare (strict_types = 1);

namespace App\PaymentMethod\Application\Factory;

use App\PaymentMethod\Application\Dto\PaymentMethodData;
use App\PaymentMethod\Application\Dto\Request\SavePaymentMethodRequest;

final readonly class PaymentMethodDataFactory
{
    public function fromRequest(SavePaymentMethodRequest $paymentMethodRequest): PaymentMethodData
    {
        return new PaymentMethodData(
            name: $paymentMethodRequest->name,
            fee: $paymentMethodRequest->fee,
            code: $paymentMethodRequest->code,
            isActive: $paymentMethodRequest->isActive,
            isRequireWebhook: $paymentMethodRequest->isRequireWebhook,
            config: $paymentMethodRequest->config,
            fileData: $paymentMethodRequest->fileData,
        );
    }
}
