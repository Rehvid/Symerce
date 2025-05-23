<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Entity\Tag;
use App\Repository\Base\AbstractRepository;

class TagDoctrineRepository extends AbstractRepository implements TagRepositoryInterface
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
