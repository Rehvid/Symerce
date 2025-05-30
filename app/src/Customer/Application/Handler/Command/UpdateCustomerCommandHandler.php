<?php

declare (strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Customer\Application\Command\UpdateCustomerCommand;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerHydrator $hydrator,
        private CustomerRepositoryInterface $repository,
    ) {
    }

    public function __invoke(UpdateCustomerCommand $command): IdResponse
    {
        $customer = $command->customer;

        $customer = $this->hydrator->hydrate($command->data, $customer);

        $this->repository->save($customer);

        return new IdResponse($customer->getId());
    }
}
