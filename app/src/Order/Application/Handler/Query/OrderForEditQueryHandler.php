<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderForEditQuery;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class OrderForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderAssembler $assembler,
        private OrderRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetOrderForEditQuery $query): array
    {

        $order = $this->repository->findById($query->orderId);
        if (null === $order) {
            throw EntityNotFoundException::for(Order::class, $query->orderId);
        }

        return $this->assembler->toFormDataResponse($order);
    }
}
