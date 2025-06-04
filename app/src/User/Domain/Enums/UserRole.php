<?php

declare(strict_types=1);

namespace App\User\Domain\Enums;

enum UserRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case EMPLOYEE = 'ROLE_EMPLOYEE';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
