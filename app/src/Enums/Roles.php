<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case ROLE_ADMIN = 'admin';
    case ROLE_USER = 'user';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
