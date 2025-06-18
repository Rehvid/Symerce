<?php

declare(strict_types=1);

namespace App\Category\Domain\Repository;

use App\Common\Domain\Entity\Category;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Category>
 */
interface CategoryRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{
    /** @return Category[] */
    public function findAllSortedByPosition(): array;

    public function findActiveSortedByPosition(): array;


    public function findBySlug(string $slug): ?Category;
}
