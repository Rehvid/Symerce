<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateCategoryDto implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public readonly string $name,
        #[Assert\NotBlank] public readonly int $parentId,
       public readonly bool $isActive = false,
       public readonly ?string $description = null,
    ) {
    }
}
