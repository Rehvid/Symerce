<?php

declare(strict_types=1);

namespace App\Order\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetOrderCustomerDetailQuery implements QueryInterface
{
    public function __construct(public int $customerId) {}
}
