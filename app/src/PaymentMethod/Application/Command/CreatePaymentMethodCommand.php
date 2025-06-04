<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\PaymentMethod\Application\Dto\PaymentMethodData;

final readonly class CreatePaymentMethodCommand implements CommandInterface
{
    public function __construct(
        public PaymentMethodData $data
    ) {

    }
}
