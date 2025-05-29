<?php

declare(strict_types=1);

namespace App\User\Application\Dto\Response;

final readonly class UserFormContext
{
    /** @param array<int, mixed> $availableRoles */
    public function __construct(
        public array $availableRoles,
    ) {
    }
}
