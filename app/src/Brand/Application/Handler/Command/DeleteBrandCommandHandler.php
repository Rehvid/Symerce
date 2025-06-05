<?php

declare(strict_types=1);

namespace App\Brand\Application\Handler\Command;

use App\Brand\Application\Command\DeleteBrandCommand;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class DeleteBrandCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BrandRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteBrandCommand $command): void
    {
        /** @var ?Brand $brand */
        $brand = $this->repository->findById($command->brandId);
        if (null === $brand) {
            throw EntityNotFoundException::for(Brand::class, $command->brandId);
        }

        $this->repository->remove($brand);
    }
}
