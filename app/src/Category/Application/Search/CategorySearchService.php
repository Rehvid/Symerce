<?php

declare(strict_types=1);

namespace App\Category\Application\Search;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;

final class CategorySearchService extends AbstractSearchService
{
    public function __construct(
        CategoryRepositoryInterface $repository,
        CategorySearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
