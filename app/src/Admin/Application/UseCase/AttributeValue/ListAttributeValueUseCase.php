<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\AttributeValue;

use App\Admin\Application\Assembler\AttributeValueAssembler;
use App\Admin\Infrastructure\Repository\AttributeValueDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListAttributeValueUseCase implements ListUseCaseInterface
{
    public function __construct(
        private AttributeValueDoctrineRepository $repository,
        private AttributeValueAssembler          $assembler,
        private PaginationService         $paginationService,
    ) {
    }

    public function execute(Request $request): mixed
    {
        $paginationResponse = $this->paginationService->buildPaginationResponse(
            $request,
            $this->repository,
            ['attributeId' => $request->get('attributeId')]
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResponse->data),
            meta: $paginationResponse->paginationMeta->toArray(),
        );
    }
}
