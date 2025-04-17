<?php

declare(strict_types=1);

namespace App\Enums;

enum SettingType: string
{
    case CURRENCY = 'currency';
    case CUSTOM = 'custom';

    /**
     * @return array<string, mixed>
     */
    public static function translatedOptions(): array
    {
        return [
            'base.setting_type' => self::CUSTOM,
        ];
    }
}
