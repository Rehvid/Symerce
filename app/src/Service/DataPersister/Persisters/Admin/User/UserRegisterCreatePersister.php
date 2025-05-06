<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\User;

use App\DTO\Admin\Request\User\StoreRegisterUserRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class UserRegisterCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [StoreRegisterUserRequestDTO::class];
    }
}
