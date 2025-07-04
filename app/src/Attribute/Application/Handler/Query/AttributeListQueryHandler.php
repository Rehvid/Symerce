<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Query;

use App\Attribute\Application\Assembler\AttributeAssembler;
use App\Attribute\Application\Query\GetAttributeListQuery;
use App\Attribute\Application\Search\AttributeSearchService;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class AttributeListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeAssembler $assembler,
        private AttributeSearchService $searchService,
    ) {
    }

    public function __invoke(GetAttributeListQuery $query): ApiResponse
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
