<?php

declare(strict_types=1);

namespace App\Cart\Application\Handler;

use App\Cart\Application\Assembler\CartAssembler;
use App\Cart\Application\Query\GetCartListQuery;
use App\Cart\Application\Search\CartSearchService;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class CartListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CartAssembler          $assembler,
        private CartSearchService     $searchService,
    ) {
    }

    public function __invoke(GetCartListQuery $query): ApiResponse
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
