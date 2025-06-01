<?php

declare(strict_types=1);

namespace App\Brand\Application\Handler\Command;

use App\Brand\Application\Command\DeleteBrandCommand;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteBrandCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BrandRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteBrandCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->brandId)
        );
    }
}
