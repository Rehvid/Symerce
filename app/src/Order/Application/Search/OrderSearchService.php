<?php

declare(strict_types=1);

namespace App\Order\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Order\Domain\Repository\OrderRepositoryInterface;

final class OrderSearchService extends AbstractSearchService
{
    public function __construct(
        OrderRepositoryInterface $repository,
        OrderSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
