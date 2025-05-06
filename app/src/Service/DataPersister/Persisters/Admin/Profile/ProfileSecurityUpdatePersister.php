<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Profile;

use App\DTO\Admin\Request\Profile\UpdateSecurityRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Base\UpdatePersister;

final class ProfileSecurityUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [UpdateSecurityRequestDTO::class, User::class];
    }
}
