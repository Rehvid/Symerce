<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Assembler\OrderAssembler;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Domain\Repository\OrderRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdOrderUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private OrderAssembler $orderAssembler,
        private OrderRepositoryInterface $orderRepository,
    ) {}

    public function execute(int|string $entityId): mixed
    {
        $order = $this->orderRepository->findById($entityId);
        if (null === $order) {
            throw new EntityNotFoundException();
        }

        return $this->orderAssembler->toFormDataResponse($order);
    }
}
