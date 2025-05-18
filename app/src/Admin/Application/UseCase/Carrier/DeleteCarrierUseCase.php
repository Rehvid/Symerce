<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Carrier;

use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteCarrierUseCase implements DeleteUseCaseInterface
{
    public function __construct(
       private CarrierRepositoryInterface $repository,
    ) {
    }


    public function execute(int|string $entityId): void
    {
        $carrier = $this->repository->findById($entityId);
        if (null === $carrier) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($carrier);
    }
}
