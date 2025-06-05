<?php

declare(strict_types=1);

namespace App\Common\Application\Search;

use App\Common\Application\Dto\Pagination\PaginationResult;
use App\Common\Application\Search\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Search\Contracts\SearchServiceInterface;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;

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

    abstract public function buildSearchCriteria(SearchData $searchData): SearchCriteria;
}
