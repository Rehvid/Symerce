<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Tag;

final readonly class TagFormResponse
{
    public function __construct(
        public string $name,
    ) {
    }
}
