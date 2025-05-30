<?php

declare(strict_types=1);

namespace App\Customer\Infrastructure\Repository;

use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

final class CustomerDoctrineRepository extends AbstractCriteriaRepository implements CustomerRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Customer::class;
    }

    protected function getAlias(): string
    {
        return 'customer';
    }
}
