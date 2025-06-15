<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Order;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Application\Mapper\OrderDataToCustomerDataMapper;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderHydrator $hydrator,
        private OrderRepositoryInterface $repository,
        private CustomerRepositoryInterface $customerRepository,
        private CustomerHydrator $customerHydrator,
        private OrderDataToCustomerDataMapper $customerDataMapper,
    ) {

    }

    public function __invoke(CreateOrderCommand $command): IdResponse
    {
        $order = $this->hydrator->hydrate($command->data, new Order());

        $this->repository->save($order);

        $customer = $command->data->customer;

        if (null !== $customer) {
            $this->customerHydrator->hydrate(
                data: $this->customerDataMapper->map($command->data),
                customer: $customer
            );
            $this->customerRepository->save($customer);
        }

        return new IdResponse($order->getId());
    }
}
