<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AttributeValue;
use App\Repository\Base\PaginationRepository;
use Doctrine\ORM\QueryBuilder;

class AttributeValueRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return AttributeValue::class;
    }

    protected function getAlias(): string
    {
        return 'attribute_value';
    }

    protected function configureQueryForPagination(
        QueryBuilder $queryBuilder,
        array $queryParams = [],
        array $additionalData = []
    ): QueryBuilder {
        $attributeId = $additionalData['attributeId'] ?? null;
        if (null === $attributeId) {
            return parent::configureQueryForPagination($queryBuilder, $queryParams, $additionalData);
        }

        return $queryBuilder
            ->andWhere('attribute_value.attribute = :attributeId')
            ->setParameter('attributeId', $attributeId);
    }
}
