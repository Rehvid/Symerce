<?php

declare(strict_types=1);

namespace App\Admin\Domain\Enums;

enum DeliveryType: string
{
    case STANDARD = 'standard';
    case EXPRESS = 'express';
    case ECONOMY = 'economy';

    /**
     * @return array<string, mixed>
     */
    public static function translatedOptions(): array
    {
        return [
            'base.delivery_type.standard' => self::STANDARD,
            'base.delivery_type.express' => self::EXPRESS,
            'base.delivery_type.economy' => self::ECONOMY,
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
