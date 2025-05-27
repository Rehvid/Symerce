<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Customer;

use App\Admin\Application\Assembler\CustomerAssembler;
use App\Admin\Application\Search\Customer\CustomerSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCustomerUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CustomerAssembler $assembler,
        private CustomerSearchService $searchService,
    ) {
    }


    public function execute(Request $request): mixed
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
