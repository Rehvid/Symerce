<?php

declare (strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Customer\Application\Command\UpdateCustomerCommand;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Exception\EntityNotFoundException;

final readonly class UpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerHydrator $hydrator,
        private CustomerRepositoryInterface $repository,
    ) {
    }

    public function __invoke(UpdateCustomerCommand $command): IdResponse
    {
        /** @var ?Customer $customer */
        $customer = $this->repository->findById($command->customerId);
        if (null === $customer) {
            throw EntityNotFoundException::for(Customer::class, $command->customerId);
        }

        $customer = $this->hydrator->hydrate($command->data, $customer);

        $this->repository->save($customer);

        return new IdResponse($customer->getId());
    }
}
