<?php

namespace App\DTO\Response\Profile;

use App\DTO\Response\ResponseInterfaceData;

final readonly class PersonalIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public string $firstname,
        public string $surname,
        public string $email,
        public string $fullName,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            firstname: $data['firstname'],
            surname: $data['surname'],
            email: $data['email'],
            fullName: $data['fullName'],
        );
    }
}
