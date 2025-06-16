<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto;

use App\Common\Application\Dto\FileData;

final readonly class PaymentMethodData
{
    public function __construct(
        public string $name,
        public string $fee,
        public string $code,
        public bool $isActive,
        public bool $isRequireWebhook,
        public array $config = [],
        public ?FileData $fileData = null,
        public ?int $id = null,
    ) {
    }
}
