<?php

declare(strict_types=1);

namespace App\Cart\Application\Search;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class CartSearchService  extends AbstractSearchService
{
    public function __construct(
        CartRepositoryInterface $repository,
        CartSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
