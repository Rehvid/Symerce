<?php

declare(strict_types=1);

namespace App\Common\Application\Service;

use App\Common\Application\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Contracts\SearchServiceInterface;
use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Dto\Pagination\PaginationResult;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractSearchService implements SearchServiceInterface
{
    public function __construct(
        protected readonly CriteriaRepositoryInterface $repository,
        protected readonly SearchParserFactoryInterface $parserFactory,
    ) {
    }

    public function search(SearchCriteria $criteria): PaginationResult
    {
        return $this->repository->findByCriteria($criteria);
    }

    abstract public function buildSearchCriteria(Request $request): SearchCriteria;
}
