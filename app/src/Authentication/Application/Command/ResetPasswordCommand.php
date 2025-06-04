<?php

declare(strict_types=1);

namespace App\Authentication\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class ResetPasswordCommand implements CommandInterface
{
    public function __construct(
        public string $token,
        public string $newPassword,
    ) {}
}
