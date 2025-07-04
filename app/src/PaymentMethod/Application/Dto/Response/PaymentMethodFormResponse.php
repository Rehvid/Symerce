<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Response;

use App\Common\Application\Dto\Response\FileResponse;

final readonly class PaymentMethodFormResponse
{
    /** @param array<mixed, mixed> $config */
    public function __construct(
        public string $code,
        public string $name,
        public string $fee,
        public bool $isActive,
        public bool $isRequireWebhook,
        public ?FileResponse $thumbnail,
        public ?array $config,
    ) {

    }
}
