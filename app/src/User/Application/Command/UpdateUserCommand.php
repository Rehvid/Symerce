<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Admin\Domain\Entity\User;
use App\Shared\Application\Command\CommandInterface;
use App\User\Application\Dto\UserData;

final readonly class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public UserData $userData,
        public User $user,
    ) {
    }
}
