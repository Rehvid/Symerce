<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Currency;

use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
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
