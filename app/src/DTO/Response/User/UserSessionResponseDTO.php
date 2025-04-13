<?php

declare(strict_types=1);

namespace App\DTO\Response\User;

use App\DTO\Response\FileResponseDTO;
use App\DTO\Response\ResponseInterfaceData;

final readonly class UserSessionResponseDTO implements ResponseInterfaceData
{
    /** @param array<int|string>  $roles */
    private function __construct(
        public ?int $id,
        public ?string $email,
        public ?string $firstname,
        public ?string $surname,
        public array $roles,
        public ?string $fullName,
        public ?FileResponseDTO $avatar,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            email: $data['email'] ?? null,
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            roles: $data['roles'] ?? [],
            fullName: $data['fullName'] ?? null,
            avatar: $data['avatar'] ?? null,
        );
    }
}
