<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class WarehouseSearchService extends AbstractSearchService
{
    public function __construct(
        WarehouseRepositoryInterface $repository,
        WarehouseSearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
