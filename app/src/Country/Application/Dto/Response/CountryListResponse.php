<?php

declare(strict_types = 1);

namespace App\Country\Application\Dto\Response;

final readonly class CountryListResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $code,
        public bool $isActive,
    ) {}
}
