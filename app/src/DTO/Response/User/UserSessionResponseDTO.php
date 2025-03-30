<?php

declare(strict_types=1);

namespace App\DTO\Response\User;

use App\DTO\Response\ResponseInterfaceData;

final readonly class UserSessionResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public ?string $email,
        public ?string $firstname,
        public ?string $surname,
        public array $roles
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            email: $data['email'] ?? null,
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            roles: $data['roles'] ?? []
        );
    }
}
