<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Assembler\DeliveryTimeAssembler;
use App\Admin\Infrastructure\Repository\DeliveryTimeDoctrineRepository;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdDeliveryTimeUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private DeliveryTimeDoctrineRepository $repository,
        private DeliveryTimeAssembler $assembler
    ) {
    }


    public function execute(int|string $entityId): mixed
    {
        $entity = $this->repository->findById($entityId);
        if (null === $entity) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($entity);
    }
}
