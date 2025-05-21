<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Application\Assembler\CurrencyAssembler;
use App\Admin\Application\Search\Currency\CurrencySearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCurrencyUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CurrencySearchService $searchService,
        private CurrencyAssembler $assembler,
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
