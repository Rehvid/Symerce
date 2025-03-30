<?php

declare(strict_types=1);

namespace App\Dto\Request\Category;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public string $name,
        public bool $isActive,
        public ?int $parentId = null,
        public ?string $description = null,
    ) {
    }
}
