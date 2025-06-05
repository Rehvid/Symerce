<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerListQuery;
use App\Customer\Application\Search\CustomerSearchService;

final readonly class CustomerListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CustomerAssembler $assembler,
        private CustomerSearchService $searchService,
    ) {
    }

    public function __invoke(GetCustomerListQuery $query): ApiResponse
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
