<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteVendorUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private VendorRepositoryInterface $repository
    ) {
    }

    public function execute(int|string $entityId): void
    {
        $tag = $this->repository->find($entityId);
        if (null === $tag) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($tag);
    }
}
