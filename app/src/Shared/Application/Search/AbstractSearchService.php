<?php

declare(strict_types=1);

namespace App\Shared\Application\Search;

use App\Shared\Application\Contract\SearchServiceInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\DTO\Pagination\PaginationResult;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractSearchService implements SearchServiceInterface
{
    public function __construct(
        protected readonly CriteriaRepositoryInterface $repository,
    ) {}

    public function search(SearchCriteria $criteria): PaginationResult
    {
        return $this->repository->findByCriteria($criteria);
    }

    abstract public function buildSearchCriteria(Request $request): SearchCriteria;
}
