<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Customer\Application\Command\UpdateCustomerCommand;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

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
