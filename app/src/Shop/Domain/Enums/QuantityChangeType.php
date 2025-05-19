<?php

declare(strict_types=1);

namespace App\Shop\Domain\Enums;

enum QuantityChangeType: string
{
    case Increase = 'increase';
    case Decrease = 'decrease';
}
