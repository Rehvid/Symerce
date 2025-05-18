<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Entity\User;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserDoctrineRepository extends AbstractRepository implements UserLoaderInterface, UserRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

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

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $this->getAlias());
        $filterBuilder
            ->applyIsActive()
        ;

        return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
    }
}
