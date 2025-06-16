<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\User\Application\Dto\ProfilePersonalData;

final readonly class UpdateUserProfilePersonalCommand implements CommandInterface
{
    public function __construct(
        public int $userId,
        public ProfilePersonalData $data,
    ) {
    }
}
