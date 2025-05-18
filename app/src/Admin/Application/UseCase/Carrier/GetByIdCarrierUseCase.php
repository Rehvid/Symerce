<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Carrier;

use App\Admin\Application\Assembler\CarrierAssembler;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Entity\Carrier;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdCarrierUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private CarrierRepositoryInterface $repository,
        private CarrierAssembler          $assembler,
    ) {
    }

    public function execute(int|string $entityId): array
    {
        /** @var ?Carrier $carrier */
        $carrier = $this->repository->findById($entityId);
        if (null === $carrier) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($carrier);
    }
}
