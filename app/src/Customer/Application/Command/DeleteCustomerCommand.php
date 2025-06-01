<?php

declare (strict_types = 1);

namespace App\Customer\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class DeleteCustomerCommand implements CommandInterface
{
    public function __construct(
        public int $customerId,
    ) {}
}
