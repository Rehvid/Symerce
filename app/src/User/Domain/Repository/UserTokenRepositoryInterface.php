<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Common\Domain\Entity\UserToken;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

interface UserTokenRepositoryInterface extends ReadWriteRepositoryInterface
{
    public function findByToken(string $token): ?UserToken;
}
