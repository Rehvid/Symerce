<?php

declare(strict_types=1);

namespace App\Tag\Infrastructure\Repository;

use App\Common\Domain\Entity\Tag;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final class TagDoctrineRepository extends AbstractCriteriaRepository implements TagRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Tag::class;
    }

    protected function getAlias(): string
    {
        return 'tag';
    }
}
