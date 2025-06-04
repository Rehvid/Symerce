<?php

declare(strict_types=1);

namespace App\Cart\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetCartDetailQuery implements QueryInterface
{
    public function __construct(
        public int $cartId,
    ) {}
}
