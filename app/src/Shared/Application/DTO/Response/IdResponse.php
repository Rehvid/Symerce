<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Response;

use JsonSerializable;

final readonly class IdResponse
{
    public function __construct(
        private int|string $id
    ) {}

    /** @return array<string, int> */
    public function toArray(): array
    {
        return [
            'id' => (int) $this->id,
        ];
    }
}
