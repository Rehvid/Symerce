<?php

declare(strict_types=1);

namespace App\Customer\Infrastructure\Repository;

use App\Common\Domain\Entity\Customer;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

/**
 * @extends AbstractCriteriaRepository<Customer>
 */
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
