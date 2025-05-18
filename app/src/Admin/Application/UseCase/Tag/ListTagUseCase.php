<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Tag;

use App\Admin\Application\Assembler\TagAssembler;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListTagUseCase implements ListUseCaseInterface
{
    public function __construct(
        private TagRepositoryInterface $repository,
        private PaginationService $paginationService,
        private TagAssembler $assembler
    ) {

    }


    public function execute(Request $request): ApiResponse
    {
        $paginationResponse = $this->paginationService->buildPaginationResponse($request, $this->repository);

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResponse->data),
            meta: $paginationResponse->paginationMeta->toArray(),
        );
    }
}
