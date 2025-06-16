<?php

declare(strict_types=1);

namespace App\Customer\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;

final class CustomerSearchService extends AbstractSearchService
{
    public function __construct(
        CustomerRepositoryInterface $repository,
        CustomerSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
