<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Profile;

use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

final readonly class PersonalIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public string $fullName,
        public ?FileResponseDTO $avatar,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            firstname: $data['firstname'],
            surname: $data['surname'],
            email: $data['email'],
            fullName: $data['fullName'],
            avatar: $data['avatar'] ?? null,
        );
    }
}
