<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Vendor;

use App\Admin\Application\Assembler\TagAssembler;
use App\Admin\Application\Assembler\VendorAssembler;
use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Admin\Infrastructure\Repository\VendorDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListVendorUseCase implements ListUseCaseInterface
{
    public function __construct(
        private VendorDoctrineRepository $repository,
        private PaginationService $paginationService,
        private VendorAssembler $assembler
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
