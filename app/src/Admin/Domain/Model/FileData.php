<?php

declare(strict_types=1);

namespace App\Admin\Domain\Model;

use App\Enums\FileMimeType;
use InvalidArgumentException;

final readonly class FileData
{
    public function __construct(
        public int $size,
        public string $name,
        public FileMimeType $type,
        public string $content,
    ) {
        $this->assertValid();
    }

    private function assertValid(): void
    {
        if ($this->size <= 0) {
            throw new InvalidArgumentException('File size must be greater than 0.');
        }

        if (empty($this->name)) {
            throw new InvalidArgumentException('File name cannot be empty.');
        }

        if (!in_array($this->type, FileMimeType::cases(), true)) {
            throw new InvalidArgumentException('Invalid MIME type.');
        }

        if (empty($this->content)) {
            throw new InvalidArgumentException('File content cannot be empty.');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            size: $data['size'] ?? 0,
            name: $data['name'] ?? '',
            type: FileMimeType::from($data['type']),
            content: $data['content'] ?? '',
        );
    }

}
