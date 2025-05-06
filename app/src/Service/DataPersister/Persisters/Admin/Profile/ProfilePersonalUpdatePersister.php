<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Profile;

use App\DTO\Admin\Request\Profile\UpdatePersonalRequestDTO;
use App\Entity\User;
use App\Service\DataPersister\Base\UpdatePersister;

final class ProfilePersonalUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [UpdatePersonalRequestDTO::class, User::class];
    }
}
