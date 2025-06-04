<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetProductHistoryQuery implements QueryInterface
{
    public function __construct(
        public int $productId
    ) {}
}
