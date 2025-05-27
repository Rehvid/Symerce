<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Order;

use App\Admin\Application\Assembler\OrderAssembler;
use App\Admin\Application\Search\Order\OrderSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListOrderUseCase implements ListUseCaseInterface
{
    public function __construct(
        private OrderAssembler $assembler,
        private OrderSearchService $searchService
    ) {}

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
