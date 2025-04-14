<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Repository\Base\PaginationRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserRepository extends PaginationRepository implements UserLoaderInterface
{

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        return $this->findOneBy(['email' => $identifier]);
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
