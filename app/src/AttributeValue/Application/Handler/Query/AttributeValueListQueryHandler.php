<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Query;

use App\AttributeValue\Application\Assembler\AttributeValueAssembler;
use App\AttributeValue\Application\Query\GetAttributeValueListQuery;
use App\AttributeValue\Application\Search\AttributeSearchValueService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class AttributeValueListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeSearchValueService $searchService,
        private AttributeValueAssembler          $assembler,
    ) {}

    public function __invoke(GetAttributeValueListQuery $query): ApiResponse
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
