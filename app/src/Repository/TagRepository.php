<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Base\PaginationRepository;

class TagRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Tag::class;
    }

    protected function getAlias(): string
    {
        return 'tag';
    }
}
