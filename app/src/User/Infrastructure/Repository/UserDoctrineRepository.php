<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\Common\Domain\Entity\User;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends AbstractCriteriaRepository<User>
 */
final class UserDoctrineRepository extends AbstractCriteriaRepository implements UserLoaderInterface, UserRepositoryInterface
{

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        /** @var User|null $entity */
        $entity = $this->findOneBy(['email' => $identifier]);

        return $entity;
    }

    protected function getEntityClass(): string
    {
        return User::class;
    }

    protected function getAlias(): string
    {
        return 'u';
    }
}
