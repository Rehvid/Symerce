<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Warehouse;
use App\Warehouse\Application\Command\CreateWarehouseCommand;
use App\Warehouse\Application\Hydrator\WarehouseHydrator;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;

final readonly class CreateWarehouseCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WarehouseHydrator $hydrator,
        private WarehouseRepositoryInterface $repository
    ) {}

    public function __invoke(CreateWarehouseCommand $command): IdResponse
    {
        $warehouse = $this->hydrator->hydrate($command->data, new Warehouse());

        $this->repository->save($warehouse);

        return new IdResponse($warehouse->getId());
    }
}
