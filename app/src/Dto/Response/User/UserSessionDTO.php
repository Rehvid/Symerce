<?php

declare(strict_types=1);

namespace App\Dto\Response\User;

use App\Dto\Response\ResponseInterfaceData;

final readonly class UserSessionDTO implements ResponseInterfaceData
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
