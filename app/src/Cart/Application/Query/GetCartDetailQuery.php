<?php

declare(strict_types=1);

namespace App\Cart\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class GetCartDetailQuery implements QueryInterface
{
    public function __construct(
        public int $cartId,
    ) {}
}
