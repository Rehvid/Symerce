<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Response;

final readonly class IdResponse
{
    public function __construct(
        private int|string|null $id
    ) {}

    /** @return array<string, int> */
    public function toArray(): array
    {
        return [
            'id' => (int) $this->id,
        ];
    }
}
