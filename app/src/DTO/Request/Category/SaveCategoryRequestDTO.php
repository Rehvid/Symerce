<?php

declare(strict_types=1);

namespace App\DTO\Request\Category;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public bool $isActive,
        public int|string|null $parentCategoryId = null,
        public ?string $description = null,
    ) {
    }
}
