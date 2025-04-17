<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Enums\FileMimeType;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class FileRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public int $size,
        #[Assert\NotBlank] public string $name,
        #[Assert\NotBlank] public FileMimeType $type,
        #[Assert\NotBlank] public string $content
    ) {
    }
}
