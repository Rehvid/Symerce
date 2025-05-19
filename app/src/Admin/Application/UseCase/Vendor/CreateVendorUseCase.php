<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Application\Hydrator\VendorHydrator;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Entity\Vendor;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateVendorUseCase implements CreateUseCaseInterface
{
    public function __construct(
      private VendorHydrator $hydrator,
      private VendorRepositoryInterface $repository,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $vendor = $this->hydrator->hydrate($requestDto, new Vendor());

        $this->repository->save($vendor);

        return (new IdResponse($vendor->getId()))->toArray();
    }
}
