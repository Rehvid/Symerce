<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Handler\Query;

use App\PaymentMethod\Application\Assembler\PaymentMethodAssembler;
use App\PaymentMethod\Application\Query\GetPaymentMethodListQuery;
use App\PaymentMethod\Application\Search\PaymentMethodSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class GetPaymentMethodListHandler implements QueryHandlerInterface
{
    public function __construct(
        private PaymentMethodSearchService $searchService,
        private PaymentMethodAssembler $assembler
    ) {
    }

    public function __invoke(GetPaymentMethodListQuery $query): ApiResponse
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
