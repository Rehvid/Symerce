<?php

declare(strict_types=1);

namespace App\Carrier\Application\Handler\Query;

use App\Carrier\Application\Assembler\CarrierAssembler;
use App\Carrier\Application\Query\GetCarrierListQuery;
use App\Carrier\Application\Search\CarrierSearchService;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class CarrierListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CarrierAssembler  $assembler,
        private CarrierSearchService $searchService,
    ) {}

    public function __invoke(GetCarrierListQuery $query): ApiResponse
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
