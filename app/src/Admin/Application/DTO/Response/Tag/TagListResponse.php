<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Tag;

final readonly class TagListResponse
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
