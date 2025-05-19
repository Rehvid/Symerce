<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Hydrator\DeliveryTimeHydrator;
use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateDeliveryTimeUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private DeliveryTimeHydrator $hydrator,
        private DeliveryTimeRepositoryInterface $repository,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $deliveryTime = $this->repository->findById($entityId);
        if (null === $deliveryTime) {
            throw new EntityNotFoundException();
        }
        $this->hydrator->hydrate($requestDto, $deliveryTime);
        $this->repository->save($deliveryTime);

        return (new IdResponse($deliveryTime->getId()))->toArray();
    }
}
