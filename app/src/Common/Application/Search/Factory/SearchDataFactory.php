<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Factory;

use App\Common\Application\Search\Contracts\SearchDefinitionInterface;
use App\Common\Application\Search\Dto\SearchData;
use App\Common\Application\Search\Extractor\DirectionExtractor;
use App\Common\Application\Search\Extractor\FilterExtractor;
use App\Common\Application\Search\Extractor\OrderByExtractor;
use Symfony\Component\HttpFoundation\Request;

final readonly class SearchDataFactory
{
    public function __construct(
        private OrderByExtractor $orderByExtractor,
        private DirectionExtractor $directionExtractor,
        private FilterExtractor $filterExtractor,
    ) {
    }

    public function fromRequest(Request $request, SearchDefinitionInterface $searchDefinition): SearchData
    {
        $limit  = $request->query->getInt('limit', 10);
        $page   = $request->query->getInt('page', 1);
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;

        return new SearchData(
            filters: $this->filterExtractor->extract($request, $searchDefinition->allowedFilters()),
            directionType: $this->directionExtractor->extract($request),
            sortBy: $this->orderByExtractor->extract($request, $searchDefinition->allowedSortFields()),
            limit: $limit,
            offset: $offset,
            page: $page
        );
    }
}
