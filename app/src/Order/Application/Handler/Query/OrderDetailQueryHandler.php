<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Domain\Entity\Order;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderDetailQuery;
use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class OrderDetailQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private OrderAssembler $assembler,
    ) {

    }

    public function __invoke(GetOrderDetailQuery $query): array
    {
        /** @var ?Order $order */
        $order = $this->orderRepository->findById($query->orderId);
        if (null === $order) {
            throw new NotFoundHttpException('Order not found');
        }

        return $this->assembler->toDetailResponse($order);
    }
}
