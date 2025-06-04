<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

enum ReductionType: string
{
    case AMOUNT = 'amount';
    case PERCENT = 'percent';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
