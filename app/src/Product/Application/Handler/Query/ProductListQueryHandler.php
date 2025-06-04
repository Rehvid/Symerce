<?php

declare (strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductListQuery;
use App\Product\Application\Search\ProductSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class ProductListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductAssembler $assembler,
        private ProductSearchService $searchService
    ) {}

    public function __invoke(GetProductListQuery $query): ApiResponse
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
