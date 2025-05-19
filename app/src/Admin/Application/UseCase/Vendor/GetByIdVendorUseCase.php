<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Application\Assembler\VendorAssembler;
use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdVendorUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private VendorRepositoryInterface $repository,
        private VendorAssembler $assembler
    ) {
    }

    public function execute(int|string $entityId): mixed
    {
        $tag = $this->repository->find($entityId);
        if (null === $tag) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($tag);
    }
}
