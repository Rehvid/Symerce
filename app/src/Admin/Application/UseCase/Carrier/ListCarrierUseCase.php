<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Carrier;

use App\Admin\Application\Assembler\CarrierAssembler;
use App\Admin\Infrastructure\Repository\CarrierDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCarrierUseCase implements ListUseCaseInterface
{
    public function __construct(
        private CarrierDoctrineRepository $repository,
        private CarrierAssembler          $assembler,
        private PaginationService         $paginationService,
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
