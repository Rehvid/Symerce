<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductListQuery;
use App\Product\Application\Search\ProductSearchService;

final readonly class ProductListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductAssembler $assembler,
        private ProductSearchService $searchService
    ) {
    }

    public function __invoke(GetProductListQuery $query): ApiResponse
    {
        $paginationResult = $this->searchService->search(
            $this->searchService->buildSearchCriteria($query->searchData)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
