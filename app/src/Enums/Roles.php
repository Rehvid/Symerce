<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case ROLE_ADMIN = 'admin';
    case ROLE_USER = 'user';
}
