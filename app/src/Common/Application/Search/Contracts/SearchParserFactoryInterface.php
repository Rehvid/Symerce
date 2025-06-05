<?php

declare (strict_types = 1);

namespace App\Common\Application\Search\Contracts;

use App\Common\Application\Search\Parser\SearchRequestParser;

interface SearchParserFactoryInterface
{
    public function create(): SearchRequestParser;
}
