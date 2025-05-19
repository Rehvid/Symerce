<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Enums\OrderByField;
use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Entity\AttributeValue;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use App\Shared\Domain\Enums\DirectionType;
use Doctrine\ORM\QueryBuilder;

class AttributeValueDoctrineRepository extends AbstractRepository implements AttributeValueRepositoryInterface
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

    public function getMaxOrder(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
