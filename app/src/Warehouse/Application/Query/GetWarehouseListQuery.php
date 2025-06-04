<?php

declare(strict_types=1);

namespace App\Warehouse\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class GetWarehouseListQuery implements QueryInterface
{
    public function __construct(public Request $request) {}
}
