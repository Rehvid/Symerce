<?php

declare (strict_types=1);

namespace App\Brand\Application\Handler\Query;

use App\Brand\Application\Assembler\BrandAssembler;
use App\Brand\Application\Query\GetBrandListQuery;
use App\Brand\Application\Search\BrandSearchService;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class BrandListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BrandSearchService $searchService,
        private BrandAssembler $assembler,
    ) {}

    public function __invoke(GetBrandListQuery $query): ApiResponse
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
