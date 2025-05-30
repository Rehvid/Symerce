<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Response;

final readonly class CustomerFormContext
{
    public function __construct(
        public array $availableCountries
    ) {}
}
