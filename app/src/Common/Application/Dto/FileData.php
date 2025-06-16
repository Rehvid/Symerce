<?php

declare(strict_types=1);

namespace App\Common\Application\Dto;

use App\Common\Domain\Enums\FileMimeType;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class FileData
{
    #[Assert\GreaterThan(0)]
    public int $size;

    #[Assert\NotBlank]
    public string $name;

    public FileMimeType $type;

    #[Assert\NotBlank]
    public string $content;


    public function __construct(
       int $size,
       string $name,
       FileMimeType $type,
       string $content,
    ) {
        $this->size = $size;
        $this->name = $name;
        $this->type = $type;
        $this->content = $content;
    }

    /** @param array<string, mixed> $data */
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
