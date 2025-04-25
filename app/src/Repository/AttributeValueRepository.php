<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AttributeValue;
use App\Repository\Base\PaginationRepository;
use App\Service\Pagination\PaginationFilters;
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
        PaginationFilters $paginationFilters
    ): QueryBuilder {

        $attributeId = $paginationFilters->getAdditionalData('attributeId');
        if (null === $attributeId) {
            return parent::configureQueryForPagination($queryBuilder, $paginationFilters);
        }

        return $queryBuilder
            ->andWhere('attribute_value.attribute = :attributeId')
            ->setParameter('attributeId', $attributeId);
    }
}
