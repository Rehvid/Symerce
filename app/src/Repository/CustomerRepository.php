<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use App\Repository\Base\DoctrineRepository;

class CustomerRepository extends DoctrineRepository
{

    protected function getEntityClass(): string
    {
        return Customer::class;
    }
}
