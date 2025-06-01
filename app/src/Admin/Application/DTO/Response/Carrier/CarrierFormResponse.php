<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Carrier;

use App\Admin\Application\DTO\Response\FileResponse;
use App\Shared\Domain\ValueObject\Money;

final readonly class CarrierFormResponse
{
    public function __construct(
        public string        $name,
        public string        $fee,
        public bool          $isActive,
        public ?FileResponse $thumbnail,
        public bool $isExternal,
        public ?array $externalData,
    ) {
    }
}
