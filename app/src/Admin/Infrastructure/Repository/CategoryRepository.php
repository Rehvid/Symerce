<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Entity\Category;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Factory\FilterBuilderFactory;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly FilterBuilderFactory $filterBuilderFactory,
    ) {
        parent::__construct($registry);
    }

    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $alias = $this->getAlias();

        $filterBuilder = $this->filterBuilderFactory->create($queryBuilder, $paginationFilters, $alias);
        $filterBuilder->applyIsActive();

        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        return $queryBuilder->orderBy("$alias.".OrderByField::ORDER->value, DirectionType::ASC->value);
    }

    public function getMaxOrder(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /** @return Category[] */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['order' => 'ASC']);
    }
}
