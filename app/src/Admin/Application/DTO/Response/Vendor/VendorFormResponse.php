<?php

declare(strict_types = 1);

namespace App\Admin\Application\DTO\Response\Vendor;

use App\DTO\Admin\Response\FileResponseDTO;

final readonly class VendorFormResponse
{
    public function __construct(
        public string $name,
        public bool $isActive,
        public ?FileResponseDTO $image,
    ) {
    }
}
