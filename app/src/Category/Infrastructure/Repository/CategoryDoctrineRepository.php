<?php

declare(strict_types=1);

namespace App\Category\Infrastructure\Repository;

use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CategoryDoctrineRepository extends AbstractCriteriaRepository implements CategoryRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }

    /** @return Category[] */
    public function findAllSortedByPosition(): array
    {
        return $this->findBy([], ['position' => 'ASC']);
    }
}
