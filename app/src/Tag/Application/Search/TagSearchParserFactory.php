<?php

declare(strict_types=1);

namespace App\Tag\Application\Search;

use App\Common\Application\Search\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Search\Filter\BasicFilterDefinition;
use App\Common\Application\Search\Parser\SearchRequestParser;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Enums\QueryOperator;
use App\Common\Infrastructure\Http\Search\SearchFilterParser;
use App\Common\Infrastructure\Http\Search\SearchOrderByParser;
use App\Common\Infrastructure\Http\Search\SearchPaginationParser;

final readonly class TagSearchParserFactory implements SearchParserFactoryInterface
{

    public function create(): SearchRequestParser
    {
        return new SearchRequestParser([
            new SearchOrderByParser(DirectionType::ASC, 'position'),
            new SearchFilterParser(),
            new SearchPaginationParser(),
        ]);
    }
}
