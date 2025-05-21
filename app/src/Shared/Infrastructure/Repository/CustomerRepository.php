<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Entity\Customer;

class CustomerRepository extends DoctrineRepository
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
