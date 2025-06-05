<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Search;

use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use Symfony\Component\HttpFoundation\Request;

final class AttributeValueSearchService extends AbstractSearchService
{

    public function __construct(
        AttributeValueRepositoryInterface $repository,
        AttributeValueSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
