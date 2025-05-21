<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Carrier;

use App\Admin\Application\Assembler\CarrierAssembler;
use App\Admin\Application\Search\Carrier\CarrierSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCarrierUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CarrierAssembler          $assembler,
        private CarrierSearchService $searchService,
    ) {
    }

    public function execute(Request $request): ApiResponse
    {
        $paginationResult = $this->searchService->search(
            $this->searchService->buildSearchCriteria($request)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
