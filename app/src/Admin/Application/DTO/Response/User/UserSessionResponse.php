<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\User;

use App\Admin\Application\DTO\Response\FileResponse;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class UserSessionResponse implements ResponseInterfaceData
{
    /** @param array<int|string>  $roles */
    public function __construct(
        public ?int          $id,
        public ?string       $email,
        public ?string       $firstname,
        public ?string       $surname,
        public array         $roles,
        public ?string       $fullName,
        public ?FileResponse $avatar = null,
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
