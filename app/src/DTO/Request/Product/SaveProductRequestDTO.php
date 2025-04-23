<?php

declare(strict_types=1);

namespace App\DTO\Request\Product;

use App\DTO\Request\PersistableInterface;
use App\Traits\FileRequestMapperTrait;

final class SaveProductRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    public function __construct(
        public string $name,
        public string $regularPrice,
        public string $discountPrice,
        public bool $isActive,
        public string|int $quantity,
        public array $categories = [],
        public array $tags = [],
        public array $deliveryTimes = [],
        public array $images = [],
        public array $attributes = [],
        public ?string $vendor = null,
        public ?string $slug = null,
        public ?string $description = null,
    ) {
        $this->images = $this->createFileRequestDTOs($this->images);
    }
}
