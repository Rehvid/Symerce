<?php

declare(strict_types=1);

namespace App\Admin\Domain\Enums;

enum PromotionSource: string
{
    case PRODUCT_TAB   = 'product_tab';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
