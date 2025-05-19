<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Assembler\ProductAssembler;
use App\Admin\Infrastructure\Repository\ProductDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListProductUseCase implements ListUseCaseInterface
{
    public function __construct(
        private ProductDoctrineRepository $repository,
        private PaginationService $paginationService,
        private ProductAssembler $assembler
    ) {
    }


    public function execute(Request $request): mixed
    {
        $paginationResponse = $this->paginationService->buildPaginationResponse($request, $this->repository);

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResponse->data),
            meta: $paginationResponse->paginationMeta->toArray(),
        );
    }
}
