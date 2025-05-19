<?php

declare(strict_types = 1);

namespace App\Admin\Application\DTO\Response\Vendor;

use App\Admin\Application\DTO\Response\FileResponse;

final readonly class VendorFormResponse
{
    public function __construct(
        public string        $name,
        public bool          $isActive,
        public ?FileResponse $image,
    ) {
    }
}
