<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query;

use App\Category\Application\Assembler\CategoryAssembler;
use App\Category\Application\Query\GetCategoryListQuery;
use App\Category\Application\Search\CategorySearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CategoryListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryAssembler $assembler,
        private CategorySearchService $searchService,
    ) {
    }

    public function __invoke(GetCategoryListQuery $query): ApiResponse
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
