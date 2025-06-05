<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Customer\Application\Command\DeleteCustomerCommand;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

final readonly class DeleteCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCustomerCommand $command): void
    {
        /** @var ?Customer $customer */
        $customer = $this->repository->findById($command->customerId);
        if (null === $customer) {
            throw EntityNotFoundException::for(Customer::class, $command->customerId);
        }

        $this->repository->remove($customer);
    }
}
