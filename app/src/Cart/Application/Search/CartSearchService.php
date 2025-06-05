<?php

declare(strict_types=1);

namespace App\Cart\Application\Search;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use Symfony\Component\HttpFoundation\Request;

final class CartSearchService  extends AbstractSearchService
{
    public function __construct(
        CartRepositoryInterface $repository,
        CartSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
