<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Assembler\SettingAssembler;
use App\Admin\Application\Search\Setting\SettingSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListSettingUseCase implements ListUseCaseInterface
{
    public function __construct(
        private SettingSearchService $searchService,
        private SettingAssembler          $assembler,
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
