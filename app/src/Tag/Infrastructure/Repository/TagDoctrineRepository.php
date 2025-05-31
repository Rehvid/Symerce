<?php

declare(strict_types=1);

namespace App\Tag\Infrastructure\Repository;

use App\Admin\Domain\Entity\Tag;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final class TagDoctrineRepository extends AbstractCriteriaRepository implements TagRepositoryInterface
{
    use ReorderRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Tag::class;
    }

    protected function getAlias(): string
    {
        return 'tag';
    }
}
