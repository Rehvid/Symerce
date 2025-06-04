<?php

declare(strict_types=1);

namespace App\Attribute\Application\Search;
use App\Attribute\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
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
