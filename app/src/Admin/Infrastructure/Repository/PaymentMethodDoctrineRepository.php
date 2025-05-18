<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Entity\PaymentMethod;
use App\Repository\Base\AbstractRepository;
use App\Shared\Infrastructure\Repository\DoctrineRepository;

//TODO: Refactor Filters
class PaymentMethodDoctrineRepository extends AbstractRepository implements PaymentMethodRepositoryInterface
{
    public function getMaxOrder(): int
    {
        $alias = $this->getAlias();

        return (int) $this->createQueryBuilder($alias)
            ->select("MAX($alias.order)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    protected function getEntityClass(): string
    {
        return PaymentMethod::class;
    }

    protected function getAlias(): string
    {
        return 'pm';
    }


}
