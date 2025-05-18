<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

final readonly class UserListResponse
{
    public function __construct(
        public int $id,
        public string $fullName,
        public string $email,
        public bool $isActive,
        public ?string $imagePath = null,
    ) {
    }
}
