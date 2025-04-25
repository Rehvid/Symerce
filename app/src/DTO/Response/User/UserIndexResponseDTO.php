<?php

declare(strict_types=1);

namespace App\DTO\Response\User;

use App\DTO\Response\ResponseInterfaceData;

final readonly class UserIndexResponseDTO implements ResponseInterfaceData
{
    private function __construct(
        public int $id,
        public string $fullName,
        public string $email,
        public ?string $imagePath = null,
        public bool $isActive,
    ) {

    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            fullName: $data['fullName'],
            email: $data['email'],
            imagePath: $data['imagePath'],
            isActive: $data['isActive'],
        );
    }
}
