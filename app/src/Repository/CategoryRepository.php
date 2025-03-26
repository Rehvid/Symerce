<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Repository\Base\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected function getEntityClass(): string
    {
        return Category::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }
}
