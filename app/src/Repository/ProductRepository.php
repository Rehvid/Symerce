<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Enums\DirectionType;
use App\Enums\OrderByField;
use App\Repository\Base\AbstractRepository;
use App\Service\Pagination\PaginationFilters;
use Doctrine\ORM\QueryBuilder;

class ProductRepository extends AbstractRepository
{
    protected function getEntityClass(): string
    {
        return Product::class;
    }

    protected function getAlias(): string
    {
        return 'p';
    }

    protected function configureQueryForPagination(QueryBuilder $queryBuilder, PaginationFilters $paginationFilters): QueryBuilder
    {
        $isActive = $paginationFilters->getQueryParam('isActive');
        if (null !== $isActive) {
            $queryBuilder->andWhere('p.isActive = :isActive')
                ->setParameter('isActive', $paginationFilters->getBooleanQueryParam('isActive'));
        }

        $quantity = $paginationFilters->getQueryParam('quantity');
        if (null !== $quantity) {
            $queryBuilder->andWhere('p.quantity = :quantity')
                ->setParameter('quantity', $quantity);
        }

        $regularPriceFrom = $paginationFilters->getQueryParam('regularPriceFrom');
        $regularPriceTo = $paginationFilters->getQueryParam('regularPriceTo');
        if (null !== $regularPriceFrom && null !== $regularPriceTo) {
            $queryBuilder
                ->andWhere('p.regularPrice BETWEEN :regularPriceFrom AND :regularPriceTo')
                ->setParameter('regularPriceFrom', $regularPriceFrom)
                ->setParameter('regularPriceTo', $regularPriceTo);
        } elseif (null !== $regularPriceFrom) {
            $queryBuilder
                ->andWhere('p.regularPrice >= :regularPriceFrom')
                ->setParameter('regularPriceFrom', $regularPriceFrom);
        } elseif (null !== $regularPriceTo) {
            $queryBuilder
                ->andWhere('p.regularPrice <= :regularPriceTo')
                ->setParameter('regularPriceTo', $regularPriceTo);
        }

        $discountPriceFrom = $paginationFilters->getQueryParam('discountPriceFrom');
        $discountPriceTo = $paginationFilters->getQueryParam('discountPriceTo');
        if (null !== $discountPriceFrom && null !== $discountPriceTo) {
            $queryBuilder
                ->andWhere('p.discountPrice BETWEEN :discountPriceFrom AND :discountPriceTo')
                ->setParameter('discountPriceFrom', $discountPriceFrom)
                ->setParameter('discountPriceTo', $discountPriceTo);
        } elseif (null !== $discountPriceFrom) {
            $queryBuilder
                ->andWhere('p.discountPrice >= :discountPriceFrom')
                ->setParameter('discountPriceFrom', $discountPriceFrom);
        } elseif (null !== $discountPriceTo) {
            $queryBuilder
                ->andWhere('p.discountPrice <= :discountPriceTo')
                ->setParameter('discountPriceTo', $discountPriceTo);
        }

        if ($paginationFilters->hasOrderBy()) {
            return $queryBuilder;
        }

        $alias = $this->getAlias();
        return $queryBuilder->orderBy("$alias." . OrderByField::ORDER->value , DirectionType::ASC->value);
    }
}
