<?php

declare(strict_types=1);

namespace App\Setting\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Setting\Domain\Repository\SettingRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class SettingSearchService extends AbstractSearchService
{
    public function __construct(
        SettingRepositoryInterface $repository,
        SettingSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
