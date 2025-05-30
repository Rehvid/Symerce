<?php

declare(strict_types=1);

namespace App\Customer\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Domain\Entity\Customer;

final readonly class GetCustomerForEditQuery implements QueryInterface
{
    public function __construct(
        public Customer $customer,
    ) {}
}
