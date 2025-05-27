<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;

class CustomerDoctrineRepository extends AbstractCriteriaRepository implements CustomerRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Customer::class;
    }

    protected function getAlias(): string
    {
        return 'c';
    }
}
