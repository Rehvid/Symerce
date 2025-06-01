<?php

declare (strict_types=1);

namespace App\Brand\Application\Handler\Query;

use App\Brand\Application\Assembler\BrandAssembler;
use App\Brand\Application\Query\GetBrandListQuery;
use App\Brand\Application\Search\BrandSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class BrandListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BrandSearchService $searchService,
        private BrandAssembler $assembler,
    ) {}

    public function __invoke(GetBrandListQuery $query): ApiResponse
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
