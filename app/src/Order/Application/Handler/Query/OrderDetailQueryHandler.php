<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Customer;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderDetailQuery;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final readonly class OrderDetailQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderAssembler $assembler,
    ) {

    }

    public function __invoke(GetOrderDetailQuery $query): array
    {

        $order = $this->orderRepository->findById($query->orderId);
        if (null === $order) {
            throw EntityNotFoundException::for(Customer::class, $query->orderId);
        }

        return $this->assembler->toDetailResponse($order);
    }
}
