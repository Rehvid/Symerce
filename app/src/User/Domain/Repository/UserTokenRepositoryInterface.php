<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Common\Domain\Entity\UserToken;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<UserToken>
 */
interface UserTokenRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    public function findByToken(string $token): ?UserToken;
}
