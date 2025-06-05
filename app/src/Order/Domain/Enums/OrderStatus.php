<?php

declare (strict_types=1);

namespace App\Order\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum OrderStatus: string
{
    use EnumValuesTrait;

    case NEW       = 'new';
    case WAITING_FOR_PAYMENT = 'waiting_for_payment';
    case PAID      = 'paid';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
