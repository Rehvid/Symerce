<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\UserToken;

use App\DTO\Admin\Request\UserToken\StoreUserTokenRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class UserTokenCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [StoreUserTokenRequestDTO::class];
    }
}
