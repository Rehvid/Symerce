<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Dto;

final readonly class CountryData
{
    public function __construct(
        public string $code,
        public string $name,
        public bool $isActive,
    ) {}
}
