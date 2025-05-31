<?php

declare(strict_types=1);

namespace App\Tag\Application\Dto;

final readonly class TagData
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public ?string $backgroundColor = null,
        public ?string $textColor = null,
    ) {
    }
}
