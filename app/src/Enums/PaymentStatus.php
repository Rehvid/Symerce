<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case UNPAID   = 'unpaid';
    case PENDING   = 'pending';
    case PAID      = 'paid';
    case FAILED    = 'failed';
    case REFUNDED  = 'refunded';
    case CANCELED  = 'canceled';
}
