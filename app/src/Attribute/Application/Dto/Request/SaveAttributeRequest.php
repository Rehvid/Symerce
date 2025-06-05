<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto\Request;

use App\Attribute\Domain\Enums\AttributeType;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [AttributeType::class, 'values'])]
    public string $type;

    #[Assert\NotBlank]
    public bool $isActive;

    public function __construct(
        string $name,
        string $type,
        bool $isActive,
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->isActive = $isActive;
    }
}
