<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum ReductionType: string
{
    use EnumValuesTrait;

    case AMOUNT = 'amount';
    case PERCENT = 'percent';

}
