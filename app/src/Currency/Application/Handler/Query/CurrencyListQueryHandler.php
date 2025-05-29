<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Query;

use App\Currency\Application\Assembler\CurrencyAssembler;
use App\Currency\Application\Query\GetCurrencyListQuery;
use App\Currency\Application\Search\CurrencySearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CurrencyListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CurrencySearchService $searchService,
        private CurrencyAssembler $assembler,
    ) {
    }

    public function __invoke(GetCurrencyListQuery $query): ApiResponse
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
