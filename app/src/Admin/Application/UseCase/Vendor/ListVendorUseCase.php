<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Application\Assembler\VendorAssembler;
use App\Admin\Application\Search\Vendor\VendorSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListVendorUseCase implements ListUseCaseInterface
{
    public function __construct(
        private VendorSearchService $searchService,
        private VendorAssembler $assembler
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
