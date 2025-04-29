<?php

declare(strict_types=1);

namespace App\DTO\Request;

final readonly class OrderRequestDTO
{
    public function __construct(
        public int $movedId,
        public int $newPosition,
        public int $oldPosition,
    ) {

    }
}
