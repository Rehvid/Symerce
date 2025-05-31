<?php

declare(strict_types=1);

namespace App\Order\Application\Handler\Query;

use App\Order\Application\Assembler\OrderAssembler;
use App\Order\Application\Query\GetOrderListQuery;
use App\Order\Application\Search\OrderSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class OrderListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private OrderAssembler $assembler,
        private OrderSearchService $searchService
    ) {}


    public function __invoke(GetOrderListQuery $query): ApiResponse
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
