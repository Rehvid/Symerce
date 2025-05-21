<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\AttributeValue;

use App\Admin\Domain\Repository\AttributeValueRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
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
