<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Country;

use App\Admin\Application\Assembler\CountryAssembler;
use App\Admin\Application\Search\Country\CountrySearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCountryUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CountryAssembler $assembler,
        private CountrySearchService $searchService,
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
