<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Category;

use App\Admin\Application\Assembler\CategoryAssembler;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCategoryUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryAssembler $assembler,
        private PaginationService $paginationService,
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
