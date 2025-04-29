<?php

declare(strict_types=1);

namespace App\Service\Pagination;

use App\Repository\Interface\PaginationRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class PaginationService
{
    public const int DEFAULT_LIMIT = 10;

    /** @param array<string, mixed> $additionalData */
    public function buildPaginationResponse(
        Request $request,
        PaginationRepositoryInterface $repository,
        array $additionalData = []
    ): PaginationResponse {
        $paginationMeta = $this->buildPaginationMeta($request);
        $paginationFilters = $this->buildPaginationFilters($request, $additionalData);

        $result = $repository->findPaginated($paginationMeta, $paginationFilters);

        $this->updatePaginationMetaFromResult($result, $paginationMeta);

        if ($paginationMeta->getTotalPages() < $paginationMeta->getPage()) {
            $paginationMeta = $this->normalizeCurrentPage($paginationMeta);
        }

        return new PaginationResponse($result['items'], $paginationMeta);
    }

    private function buildPaginationMeta(Request $request): PaginationMeta
    {
        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;

        return new PaginationMeta(
            page: $page,
            limit: $limit,
            offset: $offset
        );
    }

    /**
     * @param array<string, mixed> $additionalData
     */
    private function buildPaginationFilters(Request $request, array $additionalData = []): PaginationFilters
    {
        return new PaginationFilters(
            $request->query->all(),
            $additionalData
        );
    }

    /** @param array<string, mixed> $queryResult */
    private function updatePaginationMetaFromResult(array $queryResult, PaginationMeta $meta): void
    {
        $totalItems = $queryResult['total'];
        $totalPages = (int) ceil($totalItems / $meta->getLimit());

        $meta->setTotalItems($totalItems);
        $meta->setTotalPages($totalPages);
    }

    private function normalizeCurrentPage(PaginationMeta $meta): PaginationMeta
    {
        $newPage = 0 === $meta->getPage() - 1 ? 1 : $meta->getPage() - 1;
        $meta->setPage($newPage);

        return $meta;
    }
}
