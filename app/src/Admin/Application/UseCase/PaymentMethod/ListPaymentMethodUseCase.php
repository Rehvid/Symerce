<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Application\Assembler\PaymentMethodAssembler;
use App\Admin\Application\Search\PaymentMethod\PaymentMethodSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListPaymentMethodUseCase implements ListUseCaseInterface
{
    public function __construct(
        private PaymentMethodSearchService $searchService,
        private PaymentMethodAssembler          $assembler
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
