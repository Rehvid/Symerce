<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\User;

use App\DTO\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Base\UpdatePersister;

final class UserUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveUserRequestDTO::class, User::class];
    }
}
