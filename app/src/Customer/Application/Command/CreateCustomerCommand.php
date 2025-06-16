<?php

declare(strict_types=1);

namespace App\Customer\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Customer\Application\Dto\CustomerData;

final readonly class CreateCustomerCommand implements CommandInterface
{
    public function __construct(
        public CustomerData $data,
    ) {
    }
}
