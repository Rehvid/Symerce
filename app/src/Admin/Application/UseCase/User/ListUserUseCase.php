<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Assembler\UserAssembler;
use App\Admin\Application\Search\User\UserSearchService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListUserUseCase implements ListUseCaseInterface
{
    public function __construct(
        private UserSearchService $searchService,
        private UserAssembler $assembler
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
