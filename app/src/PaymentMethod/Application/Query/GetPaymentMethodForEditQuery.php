<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Query;

use App\Admin\Domain\Entity\PaymentMethod;
use App\Shared\Application\Query\QueryInterface;

final readonly class GetPaymentMethodForEditQuery implements QueryInterface
{
    public function __construct(
        public int $paymentMethodId
    ) {}
}
