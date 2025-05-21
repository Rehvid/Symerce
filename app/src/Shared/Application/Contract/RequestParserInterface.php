<?php

declare(strict_types=1);

namespace App\Shared\Application\Contract;

use App\Shared\Application\Builder\SearchCriteriaBuilder;
use Symfony\Component\HttpFoundation\Request;

interface RequestParserInterface
{
    public function parse(Request $request, SearchCriteriaBuilder $builder): void;
}
