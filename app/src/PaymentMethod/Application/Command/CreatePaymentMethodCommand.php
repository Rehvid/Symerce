<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Command;

use App\PaymentMethod\Application\Dto\PaymentMethodData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreatePaymentMethodCommand implements CommandInterface
{
    public function __construct(
        public PaymentMethodData $paymentMethodData
    ) {

    }
}
