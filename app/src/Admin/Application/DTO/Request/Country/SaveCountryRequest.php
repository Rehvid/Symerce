<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Country;

use App\Shared\Application\DTO\Request\RequestDtoInterface;

final readonly class SaveCountryRequest implements RequestDtoInterface
{
    public function __construct(
        public string $name,
        public string $code,
        public bool $isActive = false,
    ) {}
}
