<?php

declare(strict_types=1);

namespace App\Enums;

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
}
