<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Entity\Category;
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
