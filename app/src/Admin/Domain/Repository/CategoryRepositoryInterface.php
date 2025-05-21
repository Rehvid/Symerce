<?php

declare (strict_types = 1);

namespace App\Admin\Domain\Repository;

use App\Admin\Domain\Entity\Category;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CategoryRepositoryInterface
    extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, ReorderableRepositoryInterface
{

    /** @return Category[] */
    public function findAllOrdered(): array;
}
