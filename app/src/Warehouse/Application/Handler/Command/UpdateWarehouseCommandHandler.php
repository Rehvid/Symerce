<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Warehouse;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Warehouse\Application\Command\UpdateWarehouseCommand;
use App\Warehouse\Application\Hydrator\WarehouseHydrator;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;

final readonly class UpdateWarehouseCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WarehouseRepositoryInterface $warehouseRepository,
        private WarehouseHydrator $hydrator,
    ) {
    }

    public function __invoke(UpdateWarehouseCommand $command): IdResponse
    {
        /** @var ?Warehouse $warehouse */
        $warehouse = $this->warehouseRepository->findById($command->warehouseId);
        if (null === $warehouse) {
            throw EntityNotFoundException::for(Warehouse::class, $command->warehouseId);
        }

        $warehouse = $this->hydrator->hydrate($command->data, $warehouse);

        $this->warehouseRepository->save($warehouse);

        return new IdResponse($warehouse->getId());
    }
}
