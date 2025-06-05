<?php

declare(strict_types=1);

namespace App\Common\Domain\Traits;

trait EnumValuesTrait
{
    /**
     * @return array<int, string|int>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
