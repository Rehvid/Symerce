<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto\Response;

final readonly class AttributeFormResponse
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $isActive
    ) {
    }
}
