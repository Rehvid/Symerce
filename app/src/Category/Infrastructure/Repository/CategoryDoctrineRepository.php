<?php

declare(strict_types=1);

namespace App\Category\Infrastructure\Repository;

use App\Admin\Domain\Entity\Category;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class CategoryDoctrineRepository extends AbstractCriteriaRepository implements CategoryRepositoryInterface
{
    use ReorderRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }

    /** @return Category[] */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['order' => 'ASC']);
    }
}
