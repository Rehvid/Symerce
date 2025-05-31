<?php

namespace App\Order\Domain\Enums;

enum OrderStatus: string
{
    case NEW       = 'new';
    case WAITING_FOR_PAYMENT = 'waiting_for_payment';
    case PAID      = 'paid';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
