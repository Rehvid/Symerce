<?php

declare(strict_types=1);

namespace App\Order\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum CheckoutStep: string
{
    use EnumValuesTrait;

    case ADDRESS = 'address';
    case SHIPPING = 'shipping';
    case PAYMENT = 'payment';
    case CONFIRMATION = 'confirmation';
    case THANK_YOU = 'thank_you';
}
