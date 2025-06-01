<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Command;

use App\Order\Application\Command\UpdateOrderCommand;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\Factory\ValidationExceptionFactory;
use App\Shared\Domain\Entity\Order;
use App\Shared\Domain\Exception\EntityNotFoundException;

final readonly class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private OrderHydrator $hydrator,
    ) {}

    public function __invoke(UpdateOrderCommand $command): IdResponse
    {
        /** @var ?Order $order */
        $order = $this->repository->findById($command->orderId);
        if (null === $order) {
            throw EntityNotFoundException::for(Order::class, $command->orderId);
        }

        $order = $this->hydrator->hydrate($command->data, $order);

        return new IdResponse($order->getId());
    }
}
