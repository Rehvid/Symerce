<?php

declare(strict_types=1);

namespace App\Tag\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveTagRequest
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        public bool $isActive,
        public ?string $backgroundColor = null,
        public ?string $textColor = null,
    ) {
    }
}
