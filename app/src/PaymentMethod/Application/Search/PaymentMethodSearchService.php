<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final class PaymentMethodSearchService extends AbstractSearchService
{
    public function __construct(
        PaymentMethodRepositoryInterface $repository,
        PaymentMethodSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
