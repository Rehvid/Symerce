<?php

declare(strict_types=1);

namespace App\Enums;

enum DecimalPrecision: int
{
    case MAXIMUM_PRECISION = 20;
    case MAXIMUM_SCALE = 8;
}
