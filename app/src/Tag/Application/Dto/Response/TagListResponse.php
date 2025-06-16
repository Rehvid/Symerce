<?php

declare(strict_types=1);

namespace App\Tag\Application\Dto\Response;

final readonly class TagListResponse
{
    public function __construct(
        public int|null $id,
        public string $name,
        public bool $isActive,
    ) {
    }
}
