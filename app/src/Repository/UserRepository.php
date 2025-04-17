<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends PaginationRepository implements UserLoaderInterface
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

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, array $queryParams = []): QueryBuilder
    {
        $alias = $this->getAlias();

        return $queryBuilder
            ->select("CONCAT($alias.firstname, ' ', $alias.surname) AS fullName, $alias.id, $alias.email, avatar.path")
            ->leftJoin("$alias.avatar", 'avatar')
        ;
    }
}
