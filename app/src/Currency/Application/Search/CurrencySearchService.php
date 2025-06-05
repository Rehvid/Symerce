<?php

declare(strict_types=1);

namespace App\Currency\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class CurrencySearchService extends AbstractSearchService
{
    public function __construct(
        CurrencyRepositoryInterface $repository,
        CurrencySearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }


    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
