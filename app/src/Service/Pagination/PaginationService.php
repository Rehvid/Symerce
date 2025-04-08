<?php

declare(strict_types=1);

namespace App\Service\Pagination;

use App\Repository\Base\PaginationRepository;
use App\Repository\Interface\PaginationRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class PaginationService
{
    public const int DEFAULT_LIMIT = 10;

    public function buildPaginationResponse(Request $request, PaginationRepositoryInterface $repository): PaginationResponse
    {
        $paginationMeta = $this->buildPaginationMeta($request, $repository);

        $result = $repository->findPaginated($paginationMeta, $request->query->all());

        if (null !== $request->query->get('search') && '' !== trim($request->query->getString('search'))) {
            $paginationMeta = $this->updatePaginationMetaFromResult($result, $paginationMeta);
        }

        if ($paginationMeta->getTotalPages() < $paginationMeta->getPage()) {
            $paginationMeta = $this->normalizeCurrentPage($paginationMeta);
        }

        return new PaginationResponse($result, $paginationMeta);
    }

    private function buildPaginationMeta(Request $request, PaginationRepositoryInterface $repository): PaginationMeta
    {
        /** @phpstan-var PaginationRepository $repository */
        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        $totalItems = $repository->count();
        $totalPages = (int) ceil($totalItems / $limit);

        return new PaginationMeta(
            page: $page,
            limit: $limit,
            totalItems: $totalItems,
            totalPages: $totalPages,
            offset: $offset
        );
    }

    /** @param array<int, mixed> $queryResult */
    private function updatePaginationMetaFromResult(array $queryResult, PaginationMeta $meta): PaginationMeta
    {
        $totalItems = count($queryResult);
        $totalPages = (int) ceil($totalItems / $meta->getLimit());

        $meta->setTotalItems($totalItems);
        $meta->setTotalPages($totalPages);

        return $meta;
    }

    private function normalizeCurrentPage(PaginationMeta $meta): PaginationMeta
    {
        $newPage = 0 === $meta->getPage() - 1 ? 1 : $meta->getPage() - 1;
        $meta->setPage($newPage);

        return $meta;
    }
}
