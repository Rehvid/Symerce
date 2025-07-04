<?php

declare(strict_types=1);

namespace App\Setting\Domain\Enums;

enum SettingType: string
{
    case SYSTEM  = 'system';
    case SEO     = 'seo';
    case PRODUCT = 'product';
    case CATALOG = 'catalog';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
