<?php

declare(strict_types=1);

namespace App\Customer\Application\Dto\Response;

final readonly class CustomerListResponse
{
    public function __construct(
        public ?int $id,
        public string $fullName,
        public string $email,
        public bool $isActive = false
    ) {
    }
}
