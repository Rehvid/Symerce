<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Enums\OrderByField;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Entity\AttributeValue;
use App\Service\Pagination\PaginationFilters;
use App\Shared\Domain\Enums\DirectionType;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;
use Doctrine\ORM\QueryBuilder;

class AttributeValueDoctrineRepository extends AbstractCriteriaRepository implements AttributeValueRepositoryInterface
{
    use ReorderRepositoryTrait;

    protected function getEntityClass(): string
    {
        return AttributeValue::class;
    }

    protected function getAlias(): string
    {
        return 'attribute_value';
    }
}
