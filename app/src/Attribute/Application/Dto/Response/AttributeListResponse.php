<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto\Response;

final readonly class AttributeListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
    ) {
    }
}
