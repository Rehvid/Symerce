<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Handler\Query;

use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Warehouse\Application\Assembler\WarehouseAssembler;
use App\Warehouse\Application\Query\GetWarehouseListQuery;
use App\Warehouse\Application\Search\WarehouseSearchService;

final readonly class WarehouseListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        public WarehouseAssembler $assembler,
        public WarehouseSearchService $searchService,
    ) {}

    public function __invoke(GetWarehouseListQuery $query): ApiResponse
    {
        $paginationResult = $this->searchService->search(
            $this->searchService->buildSearchCriteria($query->request)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
