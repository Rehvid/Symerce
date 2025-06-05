<?php

declare(strict_types=1);

namespace App\Attribute\Application\Search;
use App\Attribute\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;


final class AttributeSearchService extends AbstractSearchService
{

    public function __construct(
        AttributeDoctrineRepository $repository,
        AttributeSearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
       return $this->parserFactory->create()->parse($searchData);
    }
}
