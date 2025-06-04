<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Customer\Application\Command\CreateCustomerCommand;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Enums\CustomerRole;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

final readonly class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerHydrator $hydrator,
        private CustomerRepositoryInterface $repository,
    ) {}

    public function __invoke(CreateCustomerCommand $command): IdResponse
    {
        $customer = $this->hydrator->hydrate($command->data);
        $customer->setRoles([CustomerRole::CUSTOMER]);

        $this->repository->save($customer);

        return new IdResponse($customer->getId());
    }
}
