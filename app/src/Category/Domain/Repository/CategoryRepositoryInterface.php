<?php

declare (strict_types = 1);

namespace App\Category\Domain\Repository;

use App\Admin\Domain\Repository\PositionRepositoryInterface;
use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CategoryRepositoryInterface
    extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface, PositionRepositoryInterface
{

    /** @return Category[] */
    public function findAllSortedByPosition(): array;
}
