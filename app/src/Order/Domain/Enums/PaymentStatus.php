<?php

declare(strict_types=1);

namespace App\Order\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum PaymentStatus: string
{
    use EnumValuesTrait;

    case UNPAID   = 'unpaid';
    case PENDING   = 'pending';
    case PAID      = 'paid';
    case FAILED    = 'failed';
    case REFUNDED  = 'refunded';
    case CANCELED  = 'canceled';
}
