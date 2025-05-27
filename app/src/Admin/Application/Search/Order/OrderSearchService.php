<?php

declare (strict_types=1);

namespace App\Admin\Application\Search\Order;


use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use App\Shared\Domain\Repository\OrderRepositoryInterface;
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
