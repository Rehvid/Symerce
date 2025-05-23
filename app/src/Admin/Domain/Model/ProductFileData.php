<?php

declare(strict_types=1);

namespace App\Admin\Domain\Model;

final readonly class ProductFileData
{
    public function __construct(
        public FileData $fileData,
        public bool $isThumbnail = false,
        public int|string|null $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            fileData: FileData::fromArray($data),
            isThumbnail: $data['isThumbnail'] ?? false,
            id: $data['id'] ?? null,
        );
    }
}
