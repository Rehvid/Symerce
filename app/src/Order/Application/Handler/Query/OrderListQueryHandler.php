<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderListQuery;
use App\Order\Application\Search\OrderSearchService;

final readonly class OrderListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderAssembler $assembler,
        private OrderSearchService $searchService
    ) {
    }

    public function __invoke(GetOrderListQuery $query): ApiResponse
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
