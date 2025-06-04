<?php

declare (strict_types=1);

namespace App\Order\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Order\Domain\Repository\OrderRepositoryInterface;
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
