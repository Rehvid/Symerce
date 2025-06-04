<?php

declare(strict_types=1);

namespace App\Cart\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetCartListQuery implements QueryInterface
{
    public function __construct(public Request $request) {}
}
