<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class DeletePaymentMethodCommand implements CommandInterface
{
    public function __construct(
        public int $paymentMethodId
    ) {
    }
}
