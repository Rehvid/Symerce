<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Handler\Query;

use App\Common\Domain\Entity\Warehouse;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Warehouse\Application\Assembler\WarehouseAssembler;
use App\Warehouse\Application\Query\GetWarehouseForEditQuery;
use App\Warehouse\Application\Query\GetWarehouseListQuery;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;

final readonly class WarehouseForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WarehouseRepositoryInterface $repository,
        private WarehouseAssembler $assembler
    ){}

    public function __invoke(GetWarehouseForEditQuery $query): array
    {
        /** @var Warehouse|null $warehouse */
        $warehouse = $this->repository->findById($query->warehouseId);
        if (null === $warehouse) {
            throw EntityNotFoundException::for(Warehouse::class, $query->warehouseId);
        }

        return $this->assembler->toFormDataResponse($warehouse);
    }
}
