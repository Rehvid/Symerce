<?php

declare(strict_types=1);

namespace App\Country\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Country\Domain\Repository\CountryRepositoryInterface;

final class CountrySearchService extends AbstractSearchService
{
    public function __construct(
        CountryRepositoryInterface $repository,
        CountrySearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
