<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Category;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCategoryRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public bool $isActive,
        public ?string $slug = null,
        public int|string|null $parentCategoryId = null,
        public ?string $description = null,
        public array $image = [],
    ) {

    }
}
