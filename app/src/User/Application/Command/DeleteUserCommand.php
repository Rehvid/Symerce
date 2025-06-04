<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public int $userId
    ) {
    }
}
