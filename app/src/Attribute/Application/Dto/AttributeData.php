<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto;

use App\Attribute\Domain\Enums\AttributeType;

final readonly class AttributeData
{
    public function __construct(
        public string $name,
        public AttributeType $type,
        public bool $isActive,
    ) {
    }
}
