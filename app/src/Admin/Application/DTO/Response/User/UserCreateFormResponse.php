<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

readonly class UserCreateFormResponse
{
    /** @param array<int, mixed> $availableRoles */
    public function __construct(
        public array $availableRoles,
    ) {
    }
}
