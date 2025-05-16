<?php

declare(strict_types=1);

namespace App\Enums;

enum CheckoutStep: string
{
    case ADDRESS = 'address';
    case SHIPPING = 'shipping';
    case PAYMENT = 'payment';
    case CONFIRMATION = 'confirmation';
    case THANK_YOU = 'thank_you';
}
