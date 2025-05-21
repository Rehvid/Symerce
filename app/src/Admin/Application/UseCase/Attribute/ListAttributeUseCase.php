<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Attribute;

use App\Admin\Application\Assembler\AttributeAssembler;
use App\Admin\Application\Search\Attribute\AttributeSearchService;
use App\Admin\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Service\Pagination\PaginationService;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class ListAttributeUseCase implements ListUseCaseInterface
{
    public function __construct(
        private AttributeAssembler          $assembler,
        private AttributeSearchService     $searchService,
    ) {
    }

    public function execute(Request $request): ApiResponse
    {
        $paginationResult = $this->searchService->search(
            $this->searchService->buildSearchCriteria($request)
        );

        return new ApiResponse(
            data: $this->assembler->toListResponse($paginationResult->items),
            meta: $paginationResult->paginationMeta->toArray(),
        );
    }
}
