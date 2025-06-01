<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Customer\Application\Command\DeleteCustomerCommand;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCustomerCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->customerId)
        );
    }
}
