<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Repository\Abstract;

use App\Common\Application\Dto\Pagination\PaginationMeta;
use App\Common\Application\Dto\Pagination\PaginationResult;
use App\Common\Application\Search\Dto\FilterCondition;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Domain\Enums\QueryOperator;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @template T of object
 *
 * @extends DoctrineRepository<T>
 */
abstract class AbstractCriteriaRepository extends DoctrineRepository implements CriteriaRepositoryInterface
{
    abstract protected function getAlias(): string;

    abstract protected function getEntityClass(): string;

    public function findByCriteria(SearchCriteria $criteria): PaginationResult
    {
        $alias = $this->getAlias();

        $qb = $this->createQueryBuilder($alias);

        foreach ($criteria->filters as $filterCondition) {
            $this->applyFilter($qb, $filterCondition);
        }

        if ($criteria->sortField) {
            $qb->orderBy("$alias.".$criteria->sortField, $criteria->sortDirection->value);
        }

        $countQueryBuilder = clone $qb;
        $countQueryBuilder->select("COUNT($alias.id)");
        $total = (int) $countQueryBuilder->getQuery()->getSingleScalarResult();

        $qb->setFirstResult($criteria->offset);

        if ($criteria->limit > 0) {
            $qb->setMaxResults($criteria->limit);
        }

        $items = $qb->getQuery()->getResult();


        return new PaginationResult(
            items: $items,
            paginationMeta: new PaginationMeta(
                page: $criteria->page,
                limit: $criteria->limit,
                offset: $criteria->offset,
                totalItems: $total,
                totalPages: (int) ceil($total / $criteria->limit)
            )
        );
    }

    private function applyFilter(QueryBuilder $qb, FilterCondition $filterCondition): void
    {
        $alias = $this->getAlias();
        $field = "$alias.$filterCondition->field";
        $param = str_replace('.', '_', $filterCondition->field);

        switch ($filterCondition->queryOperator) {
            case QueryOperator::EQ:
                $qb->andWhere("$field = :$param")->setParameter($param, $filterCondition->value);
                break;
            case QueryOperator::IN:
                $qb->andWhere("$field IN (:$param)")->setParameter($param, $filterCondition->value);
                break;
            case QueryOperator::BETWEEN:
                if (!is_array($filterCondition->value) || 2 !== count($filterCondition->value)) {
                    throw new \InvalidArgumentException('BETWEEN requires [from,to]');
                }
                $from = $filterCondition->value['from'] ?? null;
                $to = $filterCondition->value['to'] ?? null;

                if (null !== $from && null !== $to) {
                    $qb->andWhere("$field BETWEEN :{$param}_from AND :{$param}_to")
                        ->setParameter("{$param}_from", $from)
                        ->setParameter("{$param}_to", $to);
                } elseif (null !== $from) {
                    $qb->andWhere("$field >= :{$param}_from")
                        ->setParameter("{$param}_from", $from);
                } elseif (null !== $to) {
                    $qb->andWhere("$field <= :{$param}_to")
                        ->setParameter("{$param}_to", $to);
                }
                break;
            case QueryOperator::LIKE:
                $qb->andWhere("$field LIKE :$param")->setParameter($param, '%'.$filterCondition->value.'%');
                break;
            case QueryOperator::IS_NULL:
                $qb->andWhere("$field IS NULL");
                break;
            case QueryOperator::GT:
                $qb->andWhere("$field > :$param")->setParameter($param, $filterCondition->value);
                break;
            case QueryOperator::LT:
                $qb->andWhere("$field < :$param")->setParameter($param, $filterCondition->value);
                break;
            default:
                throw new \InvalidArgumentException('Query Operator not supported');
        }
    }
}
