<?php

declare(strict_types=1);

namespace App\Country\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class CountrySearchService extends AbstractSearchService
{

    public function __construct(
        CountryRepositoryInterface $repository,
        CountrySearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
