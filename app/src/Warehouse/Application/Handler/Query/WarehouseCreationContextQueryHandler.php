<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Warehouse\Application\Assembler\WarehouseAssembler;
use App\Warehouse\Application\Query\GetWarehouseCreationContextQuery;

final readonly class WarehouseCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WarehouseAssembler $assembler
    ) {
    }

    public function __invoke(GetWarehouseCreationContextQuery $query): array
    {
        return $this->assembler->toFormContextResponse();
    }
}
