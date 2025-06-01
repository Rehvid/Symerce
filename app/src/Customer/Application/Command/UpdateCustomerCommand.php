<?php

declare(strict_types=1);

namespace App\Customer\Application\Command;

use App\Customer\Application\Dto\CustomerData;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Domain\Entity\Customer;

final readonly class UpdateCustomerCommand implements CommandInterface
{
    public function __construct(
        public CustomerData $data,
        public int $customerId,
    ) {}
}
