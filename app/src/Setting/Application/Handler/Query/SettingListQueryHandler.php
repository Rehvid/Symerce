<?php

declare (strict_types = 1);

namespace App\Setting\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Setting\Application\Assembler\SettingAssembler;
use App\Setting\Application\Query\GetSettingListQuery;
use App\Setting\Application\Search\SettingSearchService;

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
