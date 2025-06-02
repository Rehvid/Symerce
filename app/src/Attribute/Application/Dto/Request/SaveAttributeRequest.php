<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeRequest
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)]  public string $name,
        public string $type,
        public bool $isActive,
    ) {
    }
}
