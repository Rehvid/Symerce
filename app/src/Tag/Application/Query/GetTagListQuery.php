<?php

declare(strict_types=1);

namespace App\Tag\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final class GetTagListQuery implements QueryInterface
{
    public function __construct(public Request $request) {}
}
