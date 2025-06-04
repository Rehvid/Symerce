<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Query;

use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\User\Application\Assembler\UserAssembler;
use App\User\Application\Query\GetUserListQuery;
use App\User\Application\Search\UserSearchService;

final readonly class UserListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserSearchService $searchService,
        private UserAssembler $assembler
    ) {}

    public function __invoke(GetUserListQuery $query): ApiResponse
    {
        $paginationResult = $this->searchService->search(
            $this->searchService->buildSearchCriteria($query->request)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
