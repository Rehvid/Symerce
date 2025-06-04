<?php

declare(strict_types=1);

namespace App\AttributeValue\Infrastructure\Repository;

use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;

final class AttributeValueDoctrineRepository extends AbstractCriteriaRepository implements AttributeValueRepositoryInterface
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
