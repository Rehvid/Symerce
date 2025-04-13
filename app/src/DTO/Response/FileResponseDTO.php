<?php

declare(strict_types=1);

namespace App\DTO\Response;

class FileResponseDTO implements ResponseInterfaceData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $preview,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            preview: $data['preview'] ?? null,
        );
    }
}
