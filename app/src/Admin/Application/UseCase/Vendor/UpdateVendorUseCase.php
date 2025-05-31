<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Application\Hydrator\VendorHydrator;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateVendorUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private VendorRepositoryInterface $repository,
        private VendorHydrator $hydrator,
    ) {

    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): array
    {
        $vendor = $this->repository->find($entityId);
        if (null === $vendor) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $vendor);

        $this->repository->save($vendor);

        return (new IdResponse($vendor->getId()))->toArray();
    }
}
