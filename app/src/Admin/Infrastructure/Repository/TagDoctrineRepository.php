<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Tag;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class TagDoctrineRepository extends AbstractCriteriaRepository implements TagRepositoryInterface
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
