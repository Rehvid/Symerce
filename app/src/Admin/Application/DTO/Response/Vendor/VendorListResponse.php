<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Vendor;

final readonly class VendorListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public bool $isActive,
        public ?string $imagePath = null,
    ) {
    }
}
