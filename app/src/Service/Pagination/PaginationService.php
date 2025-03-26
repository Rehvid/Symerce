<?php

declare(strict_types=1);

namespace App\Service\Pagination;

use App\Repository\Interface\BaseRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class PaginationService
{
    public const int LIMIT = 10;

    public function __construct(private readonly BaseRepositoryInterface $repository)
    {
    }

    public function createResponse(Request $request): PaginationResponse
    {
        $paginationMeta = $this->preparePaginationMeta($request);
        $data = $this->repository->findPaginated($paginationMeta);

        return new PaginationResponse($data, $paginationMeta);
    }

    private function preparePaginationMeta(Request $request): PaginationMeta
    {
        $limit = $request->query->getInt('limit', self::LIMIT);
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        $totalItems = $this->repository->count();
        $totalPages = (int) ceil($totalItems / $limit);

        return new PaginationMeta(
            page: $page,
            limit: $limit,
            totalItems: $totalItems,
            totalPages: $totalPages,
            offset: $offset
        );
    }
}
