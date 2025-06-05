<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Country\Application\Assembler\CountryAssembler;
use App\Country\Application\Query\GetCountryListQuery;
use App\Country\Application\Search\CountrySearchService;

final readonly class CountryListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryAssembler $assembler,
        private CountrySearchService $searchService,
    ) {}

    public function __invoke(GetCountryListQuery $query): ApiResponse
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
