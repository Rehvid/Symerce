<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateUserProfileSecurityCommand implements CommandInterface
{
    public function __construct(
        public int $userId,
        public string $newPassword
    ) {}
}
