<?php

declare(strict_types=1);

namespace App\Customer\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetCustomerForEditQuery implements QueryInterface
{
    public function __construct(
        public int $customerId,
    ) {}
}
