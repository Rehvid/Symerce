<?php

declare(strict_types=1);

namespace App\Tag\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final class TagSearchService extends AbstractSearchService
{
    public function __construct(
        TagRepositoryInterface $repository,
        TagSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
