<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

enum DecimalPrecision: int
{
    case MAXIMUM_PRECISION = 20;
    case MAXIMUM_SCALE = 8;
}
