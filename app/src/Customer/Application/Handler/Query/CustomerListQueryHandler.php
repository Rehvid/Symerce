<?php

declare(strict_types=1);

namespace App\Customer\Application\Handler\Query;

use App\Customer\Application\Assembler\CustomerAssembler;
use App\Customer\Application\Query\GetCustomerListQuery;
use App\Customer\Application\Search\CustomerSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

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
            $this->searchService->buildSearchCriteria($query->request)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
