<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response;

use App\Shared\Domain\Enums\SettingType;

class ProviderResponse
{
    /** @param array<int,mixed>|string $value  */
    public function __construct(
        public SettingType $type,
        public array|string $value
    ) {

    }
}
