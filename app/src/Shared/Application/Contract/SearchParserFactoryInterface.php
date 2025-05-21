<?php

declare (strict_types = 1);

namespace App\Shared\Application\Contract;

use App\Shared\Application\Parser\SearchRequestParser;

interface SearchParserFactoryInterface
{
    public function create(): SearchRequestParser;
}
