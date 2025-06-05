<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Query;

use App\AttributeValue\Application\Assembler\AttributeValueAssembler;
use App\AttributeValue\Application\Query\GetAttributeValueListQuery;
use App\AttributeValue\Application\Search\AttributeValueSearchService;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class AttributeValueListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeValueSearchService $searchService,
        private AttributeValueAssembler     $assembler,
    ) {}

    public function __invoke(GetAttributeValueListQuery $query): ApiResponse
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
