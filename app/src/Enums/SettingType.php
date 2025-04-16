<?php

declare(strict_types=1);

namespace App\Enums;

enum SettingType: string
{
    case CURRENCY = 'currency';
    case OTHER = 'other';

    public static function valuesNotProtected(): array
    {
        return [self::OTHER];
    }

    public static function valuesNotProtectedWithLabels(): array
    {
        return [
            'base.setting_type' => self::OTHER
        ];
    }
}
