<?php

declare (strict_types = 1);

namespace App\Setting\Application\Handler\Query;

use App\Setting\Application\Assembler\SettingAssembler;
use App\Setting\Application\Query\GetSettingListQuery;
use App\Setting\Application\Search\SettingSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class SettingListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SettingSearchService $searchService,
        private SettingAssembler $assembler,
    ) {}

    public function __invoke(GetSettingListQuery $query): ApiResponse
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
