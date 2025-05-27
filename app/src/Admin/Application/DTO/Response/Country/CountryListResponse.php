<?php

declare(strict_types = 1);

namespace App\Admin\Application\DTO\Response\Country;

final readonly class CountryListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public bool $isActive,
    ) {}
}
