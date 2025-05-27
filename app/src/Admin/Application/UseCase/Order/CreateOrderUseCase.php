<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Hydrator\Order\OrderHydrator;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Domain\Repository\OrderRepositoryInterface;

final readonly class CreateOrderUseCase implements CreateUseCaseInterface
{
    public function __construct(
        public OrderHydrator $hydrator,
        public OrderRepositoryInterface $repository,
    ) {

    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $order = $this->hydrator->hydrate($requestDto);

        $this->repository->save($order);

        return (new IdResponse($order->getId()))->toArray();
    }
}
