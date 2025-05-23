<?php

declare (strict_types = 1);

namespace App\Admin\Domain\Repository;

use App\Entity\Category;

interface CategoryRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface
{
    public function getMaxOrder(): int;

    /** @return Category[] */
    public function findAllOrdered(): array;
}
