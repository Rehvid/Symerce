<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Search;

use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class AttributeSearchValueService extends AbstractSearchService
{

    public function __construct(
        AttributeValueRepositoryInterface $repository,
        AttributeSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
