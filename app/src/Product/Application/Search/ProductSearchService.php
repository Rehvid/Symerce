<?php

declare(strict_types=1);

namespace App\Product\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Product\Domain\Repository\ProductRepositoryInterface;


final class ProductSearchService extends AbstractSearchService
{

    public function __construct(
        ProductRepositoryInterface $repository,
        ProductSearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
