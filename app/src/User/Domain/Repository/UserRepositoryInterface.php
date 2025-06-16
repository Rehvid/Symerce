<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Common\Domain\Entity\User;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends QueryRepositoryInterface<User>
 */
interface UserRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface
{
    public function loadUserByIdentifier(string $identifier): ?UserInterface;
}
