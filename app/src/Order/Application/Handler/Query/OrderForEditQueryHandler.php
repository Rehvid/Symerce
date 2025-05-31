<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderForEditQuery;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Domain\Entity\Order;


final readonly class OrderForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderAssembler $assembler,
        private OrderRepositoryInterface $repository,
    ) {}

    public function __invoke(GetOrderForEditQuery $query): array
    {
        /** @var Order $order */
        $order = $this->repository->findById($query->orderId);
        if (null === $order) {
            return [];
        }

        return $this->assembler->toFormDataResponse($order);
    }
}
