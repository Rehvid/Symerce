<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class AttributeDoctrineRepository extends AbstractRepository implements AttributeRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return Attribute::class;
    }

    protected function getAlias(): string
    {
        return 'attribute';
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @return array<int, mixed>
     */
    public function getAttributeValuesByAttributes(array $attributes): array
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $qb->select('av')
            ->from(AttributeValue::class, 'av');

        $orX = $qb->expr()->orX();

        foreach ($attributes as $attributeId => $valueIds) {
            $paramAttr = 'attr_'.$attributeId;
            $paramVals = 'vals_'.$attributeId;

            $orX->add(
                $qb->expr()->andX(
                    $qb->expr()->eq('av.attribute', ":$paramAttr"),
                    $qb->expr()->in('av.id', ":$paramVals")
                )
            );

            $qb->setParameter($paramAttr, $attributeId);
            $qb->setParameter($paramVals, $valueIds);
        }

        $qb->where($orX);

        return $qb->getQuery()->getResult();
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        $alias = $this->getAlias();

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
