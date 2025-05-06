<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\User;

use App\DTO\Admin\Request\User\SaveUserRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class UserCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveUserRequestDTO::class];
    }
}
