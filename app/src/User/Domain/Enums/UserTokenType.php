<?php

declare(strict_types=1);

namespace App\User\Domain\Enums;

enum UserTokenType: string
{
    case FORGOT_PASSWORD = 'forgot_password';
}
