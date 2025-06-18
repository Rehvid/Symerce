<?php

declare(strict_types=1);

namespace App\Category\Infrastructure\Repository;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;

/**
 * @extends AbstractCriteriaRepository<Category>
 */
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

    public function findActiveSortedByPosition(): array
    {
        return $this->findBy(['isActive' => true], ['position' => 'ASC']);
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->findOneBy(['slug' => $slug, 'isActive' => true]);
    }
}
