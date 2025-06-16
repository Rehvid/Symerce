<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Response;

use App\Common\Application\Dto\Response\FileResponse;

final readonly class CategoryFormResponse
{
    public function __construct(
        public ?string $name,
        public ?string $slug,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public bool $isActive,
        public ?int $parentCategoryId = null,
        public ?string $description = null,
        public ?FileResponse $thumbnail = null,
    ) {

    }
}
