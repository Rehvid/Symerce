<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Country;

final readonly class CountryFormResponse
{
    public function __construct(
        public string $name,
        public string $code,
        public bool $isActive,
    ) {}
}
