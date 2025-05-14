<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW       = 'new';
    case PAID      = 'paid';
    case SHIPPED   = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
