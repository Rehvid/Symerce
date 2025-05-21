<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Product;

use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
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
