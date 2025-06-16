<?php

declare(strict_types=1);

namespace App\User\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum UserRole: string
{
    use EnumValuesTrait;

    case ADMIN = 'ROLE_ADMIN';
    case EMPLOYEE = 'ROLE_EMPLOYEE';
}
