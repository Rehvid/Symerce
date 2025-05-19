<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Assembler\SettingAssembler;
use App\Admin\Infrastructure\Repository\SettingDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListSettingUseCase implements ListUseCaseInterface
{
    public function __construct(
        private SettingDoctrineRepository $repository,
        private SettingAssembler          $assembler,
        private PaginationService         $paginationService,
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
