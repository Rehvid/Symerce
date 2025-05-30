<?php

declare (strict_types = 1);

namespace App\Customer\Application\Command;

use App\Customer\Application\Dto\CustomerData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public CustomerData $data,
    ) {}
}
