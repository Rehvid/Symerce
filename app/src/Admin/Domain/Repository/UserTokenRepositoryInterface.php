<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Admin\Domain\Entity\UserToken;

interface UserTokenRepositoryInterface extends ReadWriteRepositoryInterface
{
    public function findByToken(string $token): ?UserToken;
}
