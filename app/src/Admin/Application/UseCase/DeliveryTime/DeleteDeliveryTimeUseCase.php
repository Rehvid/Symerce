<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteDeliveryTimeUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private DeliveryTimeRepositoryInterface $repository
    ) {}

    public function execute(int|string $entityId): void
    {
        $deliveryTime = $this->repository->findById($entityId);
        if ($deliveryTime === null) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($deliveryTime);
    }
}
