<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\User;

use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class UserFormResponseDTO implements ResponseInterfaceData
{
    /** @param array<int|string>  $roles */
    private function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public bool $isActive,
        public ?array $roles,
        public ?FileResponseDTO $avatar,
    ) {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            firstname: $data['firstname'] ?? null,
            surname: $data['surname'] ?? null,
            email: $data['email'] ?? null,
            isActive: $data['isActive'] ?? false,
            roles: $data['roles'] ?? [],
            avatar: $data['avatar'] ?? null,
        );
    }
}
