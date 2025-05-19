<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request;

use App\Admin\Domain\Enums\FileMimeType;
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
