<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\PaymentMethod\Application\Assembler\PaymentMethodAssembler;
use App\PaymentMethod\Application\Query\GetPaymentMethodListQuery;
use App\PaymentMethod\Application\Search\PaymentMethodSearchService;

final readonly class PaymentMethodListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PaymentMethodSearchService $searchService,
        private PaymentMethodAssembler $assembler
    ) {
    }

    public function __invoke(GetPaymentMethodListQuery $query): ApiResponse
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
