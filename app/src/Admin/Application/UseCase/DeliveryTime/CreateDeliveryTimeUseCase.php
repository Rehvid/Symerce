<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Hydrator\DeliveryTimeHydrator;
use App\Admin\Domain\Entity\DeliveryTime;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateDeliveryTimeUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private DeliveryTimeHydrator $hydrator,
        private DeliveryTimeRepositoryInterface $repository,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): mixed
    {
        $deliveryTime = new DeliveryTime();
        $deliveryTime->setOrder($this->repository->getMaxOrder() + 1);

        $this->hydrator->hydrate($requestDto, $deliveryTime);
        $this->repository->save($deliveryTime);

        return (new IdResponse($deliveryTime->getId()))->toArray();
    }
}
