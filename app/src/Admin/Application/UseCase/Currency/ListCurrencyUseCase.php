<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Application\Assembler\CurrencyAssembler;
use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Admin\Infrastructure\Repository\CurrencyDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListCurrencyUseCase implements ListUseCaseInterface
{
    public function __construct(
        private PaginationService $paginationService,
        private CurrencyAssembler $assembler,
        private CurrencyDoctrineRepository $repository,
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
