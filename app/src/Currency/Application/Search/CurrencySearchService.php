<?php

declare(strict_types=1);

namespace App\Currency\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class CurrencySearchService extends AbstractSearchService
{
    public function __construct(
        CurrencyRepositoryInterface $repository,
        CurrencySearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }


    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
