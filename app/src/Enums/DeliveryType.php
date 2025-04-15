<?php

declare(strict_types=1);

namespace App\Enums;

enum DeliveryType: string
{
    case STANDARD = 'Standard';
    case EXPRESS = 'Express';
    case ECONOMY = 'Economy';
}
