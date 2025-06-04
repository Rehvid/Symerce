<?php

declare (strict_types = 1);

namespace App\Common\Application\Contracts;

use App\Common\Application\Parser\SearchRequestParser;

interface SearchParserFactoryInterface
{
    public function create(): SearchRequestParser;
}
