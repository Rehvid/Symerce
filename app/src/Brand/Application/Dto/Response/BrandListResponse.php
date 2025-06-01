<?php

declare(strict_types=1);

namespace App\Brand\Application\Dto\Response;

final readonly class BrandListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public ?string $imagePath = null,
    ) {
    }
}
