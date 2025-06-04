<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Http;

use App\Common\Application\Builder\SearchCriteriaBuilder;
use App\Common\Application\Contracts\RequestParserInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class SearchPaginationParser implements RequestParserInterface
{
    public function parse(Request $request, SearchCriteriaBuilder $builder): void
    {
        $limit  = $request->query->getInt('limit', 10);
        $page   = $request->query->getInt('page', 1);
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;
        $builder->paginate(
            limit: $limit,
            offset: $offset,
            page: $page,
        );
    }
}
