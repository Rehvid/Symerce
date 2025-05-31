<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Command;

use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderHydrator $hydrator,
        private OrderRepositoryInterface $repository,
    ) {

    }

    public function __invoke(CreateOrderCommand $command): IdResponse
    {
        $order = $this->hydrator->hydrate($command->data);

        $this->repository->save($order);

        return new IdResponse($order->getId());
    }
}
