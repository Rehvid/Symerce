<?php

declare(strict_types=1);

namespace App\Order\Application\Search;

use App\Common\Application\Search\Contracts\SearchParserFactoryInterface;
use App\Common\Application\Search\Parser\SearchRequestParser;
use App\Common\Domain\Enums\DirectionType;
use App\Common\Infrastructure\Http\Search\SearchFilterParser;
use App\Common\Infrastructure\Http\Search\SearchOrderByParser;
use App\Common\Infrastructure\Http\Search\SearchPaginationParser;

final readonly class OrderSearchParserFactory implements SearchParserFactoryInterface
{
    public function create(): SearchRequestParser
    {
        return new SearchRequestParser([
            new SearchOrderByParser(DirectionType::DESC, 'id'),
            new SearchFilterParser(),
            new SearchPaginationParser(),
        ]);
    }
}
