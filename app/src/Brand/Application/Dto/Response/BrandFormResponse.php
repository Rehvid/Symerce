<?php

declare(strict_types = 1);

namespace App\Brand\Application\Dto\Response;

use App\Admin\Application\DTO\Response\FileResponse;

final readonly class BrandFormResponse
{
    public function __construct(
        public string        $name,
        public bool          $isActive,
        public ?FileResponse $thumbnail,
    ) {
    }
}
