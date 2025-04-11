<?php

declare(strict_types=1);

namespace App\DTO\Request;

final readonly class OrderRequestDTO
{
    /** @param array<int, int> $order */
    public function __construct(
        public array $order
    ) {

    }
}
