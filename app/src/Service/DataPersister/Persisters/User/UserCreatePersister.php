<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\User;

use App\DTO\Request\User\SaveUserRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class UserCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveUserRequestDTO::class];
    }
}
