<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

use App\Common\Application\Search\Builder\SearchCriteriaBuilder;
use App\Common\Application\Search\Dto\SearchData;

interface SearchParserInterface
{
    public function parse(SearchData $data, SearchCriteriaBuilder $builder): void;
}
