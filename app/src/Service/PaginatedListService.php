<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\ArrayableInterface;
use App\Repository\Interface\BaseRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class PaginatedListService
{
    public function __construct(private BaseRepositoryInterface $repository)
    {}

    public function getListResponse(Request $request): array
    {
        $data = array_map(
            static fn (ArrayableInterface $object) => $object->toArray(),
            $this->repository->findPaginated($request->query->all())
        );

        return [
            'data' => $data,
            'rendered' => count($data),
            'total' => $this->repository->count(),
            'success' => true
        ];
    }
}
