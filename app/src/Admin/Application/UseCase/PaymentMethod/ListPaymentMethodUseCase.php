<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\PaymentMethod;

use App\Admin\Application\Assembler\PaymentMethodAssembler;
use App\Admin\Infrastructure\Repository\PaymentMethodDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListPaymentMethodUseCase implements ListUseCaseInterface
{
    public function __construct(
        private PaymentMethodDoctrineRepository $repository,
        private PaginationService               $paginationService,
        private PaymentMethodAssembler          $assembler
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
