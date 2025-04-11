<?php

declare(strict_types=1);

namespace App\DTO\Response;

class FileResponseDTO implements ResponseInterfaceData
{
    public function __construct(
        public ?int $id,
        public ?string $originalName,
        public ?string $path,
    ) {
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'] ?? null,
            originalName: $data['originalName'] ?? null,
            path: $data['path'] ?? null,
        );
    }
}
