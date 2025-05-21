<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Assembler\DeliveryTimeAssembler;
use App\Admin\Application\Search\DeliveryTime\DeliveryTimeSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListDeliveryTimeUseCase implements ListUseCaseInterface
{
    public function __construct(
        private DeliveryTimeSearchService $searchService,
        private DeliveryTimeAssembler $assembler
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
