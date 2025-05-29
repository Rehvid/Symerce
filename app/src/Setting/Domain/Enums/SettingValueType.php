<?php

declare(strict_types=1);

namespace App\Setting\Domain\Enums;

enum SettingValueType: string
{
    case STRING = 'string';
    case BOOLEAN = 'boolean';
    case JSON = 'json';
    case INTEGER = 'integer';
    case FLOAT = 'float';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
