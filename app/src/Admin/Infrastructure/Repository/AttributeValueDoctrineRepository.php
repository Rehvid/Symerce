<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\AttributeValue;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Service\Pagination\PaginationFilters;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class AttributeValueDoctrineRepository extends AbstractCriteriaRepository implements AttributeValueRepositoryInterface
{
    use PositionRepositoryTrait;

    protected function getEntityClass(): string
    {
        return AttributeValue::class;
    }

    protected function getAlias(): string
    {
        return 'attribute_value';
    }
}
