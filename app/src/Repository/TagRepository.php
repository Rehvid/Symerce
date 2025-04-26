<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Repository\Base\AbstractRepository;

class TagRepository extends AbstractRepository
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
