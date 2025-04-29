<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AttributeValue;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class AttributeValueRepository extends AbstractRepository
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

        $alias = $this->getAlias();

        $queryBuilder
            ->andWhere("$alias.attribute = :attributeId")
            ->setParameter('attributeId', $attributeId)
        ;

        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        return $queryBuilder->orderBy("$alias.".OrderByField::ORDER->value, DirectionType::ASC->value);
    }
}
