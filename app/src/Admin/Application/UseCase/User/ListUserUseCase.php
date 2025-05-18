<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Assembler\UserAssembler;
use App\Admin\Infrastructure\Repository\UserDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListUserUseCase implements ListUseCaseInterface
{
    public function __construct(
        private UserDoctrineRepository $repository, //TODO: Change
        private PaginationService $paginationService,
        private UserAssembler $assembler
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
