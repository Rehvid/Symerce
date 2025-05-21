<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Attribute;
use App\Admin\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class AttributeSearchService extends AbstractSearchService
{

    public function __construct(
        AttributeDoctrineRepository $repository,
        AttributeSearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
       return $this->parserFactory->create()->parse($request);
    }
}
