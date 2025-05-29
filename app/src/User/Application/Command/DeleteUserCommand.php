<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Admin\Domain\Entity\User;
use App\Shared\Application\Command\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public User $user,
    ) {
    }
}
