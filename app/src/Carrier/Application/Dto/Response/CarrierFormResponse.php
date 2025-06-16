<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto\Response;

use App\Common\Application\Dto\Response\FileResponse;

final readonly class CarrierFormResponse
{
    public function __construct(
        public string $name,
        public string $fee,
        public bool $isActive,
        public ?FileResponse $thumbnail,
        public bool $isExternal,
        public ?array $externalData,
    ) {
    }
}
