<?php

declare (strict_types = 1);

namespace App\Customer\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Domain\Entity\Customer;

final readonly class DeleteCustomerCommand implements CommandInterface
{
    public function __construct(
        public Customer $customer,
    ) {}
}
