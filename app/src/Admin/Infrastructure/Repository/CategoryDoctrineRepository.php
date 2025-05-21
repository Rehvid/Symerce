<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Entity\Category;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CategoryDoctrineRepository extends AbstractCriteriaRepository implements CategoryRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
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
