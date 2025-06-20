<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Customer\Application\Hydrator\CustomerHydrator;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Order\Application\Command\UpdateOrderCommand;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Application\Mapper\OrderDataToCustomerDataMapper;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private OrderHydrator $hydrator,
        private CustomerRepositoryInterface $customerRepository,
        private CustomerHydrator $customerHydrator,
        private OrderDataToCustomerDataMapper $customerDataMapper,
    ) {
    }

    public function __invoke(UpdateOrderCommand $command): IdResponse
    {
        /** @var ?Order $order */
        $order = $this->repository->findById($command->orderId);
        if (null === $order) {
            throw EntityNotFoundException::for(Order::class, $command->orderId);
        }

        $order = $this->hydrator->hydrate($command->data, $order);

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
