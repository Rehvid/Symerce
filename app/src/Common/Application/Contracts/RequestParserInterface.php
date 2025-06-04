<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

use App\Common\Application\Builder\SearchCriteriaBuilder;
use Symfony\Component\HttpFoundation\Request;

interface RequestParserInterface
{
    public function parse(Request $request, SearchCriteriaBuilder $builder): void;
}
