<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Command;

use App\Admin\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Application\Dto\PaymentMethodData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdatePaymentMethodCommand implements CommandInterface
{
    public function __construct(
        public PaymentMethodData $paymentMethodData,
        public PaymentMethod $paymentMethod,
    ) {

    }
}
