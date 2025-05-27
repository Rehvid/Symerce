<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Hydrator\Order\OrderHydrator;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Domain\Repository\OrderRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateOrderUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private OrderHydrator $hydrator,
    ) {}


    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $order = $this->repository->find($entityId);
        if (null === $order) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $order);

        $this->repository->save($order);

        return (new IdResponse($order->getId()))->toArray();
    }
}
