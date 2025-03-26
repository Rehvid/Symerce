<?php

declare(strict_types=1);

namespace App\Dto\Request\Category;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryDto implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public readonly string $name,
        public readonly ?int $parentId = null,
        public readonly bool $isActive = false,
        public readonly ?string $description = null,
    ) {
    }
}
