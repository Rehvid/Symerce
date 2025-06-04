<?php

declare(strict_types=1);

namespace App\Tag\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Tag\Application\Assembler\TagAssembler;
use App\Tag\Application\Query\GetTagListQuery;
use App\Tag\Application\Search\TagSearchService;

final readonly class TagListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private TagSearchService $searchService,
        private TagAssembler $assembler
    ) {

    }

    public function __invoke(GetTagListQuery $query): ApiResponse
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
