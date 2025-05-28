<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Query;

use App\Country\Application\Assembler\CountryAssembler;
use App\Country\Application\Query\GetCountryListQuery;
use App\Country\Application\Search\CountrySearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class GetCountryListHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryAssembler $assembler,
        private CountrySearchService $searchService,
    ) {}

    public function __invoke(GetCountryListQuery $query): ApiResponse
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
