<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Assembler\DeliveryTimeAssembler;
use App\Admin\Infrastructure\Repository\DeliveryTimeDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListDeliveryTimeUseCase implements ListUseCaseInterface
{
    public function __construct(
        private DeliveryTimeDoctrineRepository $repository,
        private PaginationService $paginationService,
        private DeliveryTimeAssembler $assembler
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
