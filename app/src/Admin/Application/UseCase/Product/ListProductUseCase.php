<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Assembler\ProductAssembler;
use App\Admin\Application\Search\Product\ProductSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListProductUseCase implements ListUseCaseInterface
{
    public function __construct(
        private ProductAssembler $assembler,
        private ProductSearchService $searchService
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
