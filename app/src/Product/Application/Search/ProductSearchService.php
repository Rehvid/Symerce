<?php

declare(strict_types=1);

namespace App\Product\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class ProductSearchService extends AbstractSearchService
{

    public function __construct(
        ProductRepositoryInterface $repository,
        ProductSearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
