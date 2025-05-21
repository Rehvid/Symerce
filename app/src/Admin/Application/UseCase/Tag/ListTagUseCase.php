<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Application\Assembler\TagAssembler;
use App\Admin\Application\Search\Tag\TagSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListTagUseCase implements ListUseCaseInterface
{
    public function __construct(
        private TagSearchService $searchService,
        private TagAssembler $assembler
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
