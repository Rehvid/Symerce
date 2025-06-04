<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\User\Application\Dto\UserData;

final readonly class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public UserData $data,
        public int  $userId,
    ) {
    }
}
