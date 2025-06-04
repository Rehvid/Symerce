<?php

declare(strict_types = 1);

namespace App\Tag\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Tag\Domain\Repository\TagRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class TagSearchService extends AbstractSearchService
{
    public function __construct(
        TagRepositoryInterface $repository,
        TagSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
