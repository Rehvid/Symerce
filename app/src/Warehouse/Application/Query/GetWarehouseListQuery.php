<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetWarehouseListQuery implements QueryInterface
{
    public function __construct(public Request $request) {}
}
