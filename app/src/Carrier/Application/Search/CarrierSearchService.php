<?php

declare(strict_types=1);

namespace App\Carrier\Application\Search;

use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;

final class CarrierSearchService extends AbstractSearchService
{
    public function __construct(
        CarrierRepositoryInterface $repository,
        CarrierSearchFactoryParser $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
