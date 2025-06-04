<?php

declare (strict_types = 1);

namespace App\Warehouse\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Warehouse\Application\Command\DeleteWarehouseCommand;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;

final readonly class DeleteWarehouseCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WarehouseRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteWarehouseCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->warehouseId)
        );
    }
}
