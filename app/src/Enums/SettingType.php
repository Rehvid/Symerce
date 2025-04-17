<?php

declare(strict_types=1);

namespace App\Enums;

enum SettingType: string
{
    case CURRENCY = 'currency';
    case CUSTOM = 'custom';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

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
