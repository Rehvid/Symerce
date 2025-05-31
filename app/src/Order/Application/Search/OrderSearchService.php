<?php

declare (strict_types=1);

namespace App\Order\Application\Search;

use App\Order\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class OrderSearchService extends AbstractSearchService
{
    public function __construct(
        OrderRepositoryInterface $repository,
        OrderSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
