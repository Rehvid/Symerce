<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Order;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Application\Hydrator\OrderHydrator;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderHydrator $hydrator,
        private OrderRepositoryInterface $repository,
    ) {

    }

    public function __invoke(CreateOrderCommand $command): IdResponse
    {
        $order = $this->hydrator->hydrate($command->data, new Order());

        $this->repository->save($order);

        return new IdResponse($order->getId());
    }
}
