<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
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

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
