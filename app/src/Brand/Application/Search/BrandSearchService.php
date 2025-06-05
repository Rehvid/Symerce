<?php

declare(strict_types=1);

namespace App\Brand\Application\Search;

use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use Symfony\Component\HttpFoundation\Request;

final class BrandSearchService extends AbstractSearchService
{
    public function __construct(
        BrandRepositoryInterface  $repository,
        BrandSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
