<?php

declare(strict_types=1);

namespace App\Admin\Domain\Enums;

enum TokenType: string
{
    case FORGOT_PASSWORD = 'forgot_password';
}
