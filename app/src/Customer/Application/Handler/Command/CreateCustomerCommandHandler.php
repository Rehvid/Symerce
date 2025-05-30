<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Customer\Application\Command\CreateCustomerCommand;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Entity\Customer;
use App\Shared\Domain\Enums\CustomerRole;

final readonly class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerHydrator $hydrator,
        private CustomerRepositoryInterface $repository,
    ) {}

    public function __invoke(CreateCustomerCommand $command): IdResponse
    {
        $customer = new Customer();
        $customer->setRoles([CustomerRole::CUSTOMER]);

        $customer = $this->hydrator->hydrate($command->data, $customer);

        $this->repository->save($customer);

        return new IdResponse($customer->getId());
    }
}
