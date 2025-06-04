<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Response;

class FileResponse
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $preview,
    ) {
    }

    public static function fromArray(array $data)
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            preview: $data['preview'] ?? null,
        );
    }
}
