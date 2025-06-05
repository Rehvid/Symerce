<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    public string $value;

    #[Assert\NotBlank]
    public int $attributeId;

    public function __construct(
        string $value,
        int $attributeId
    ) {
        $this->value = $value;
        $this->attributeId = $attributeId;
    }
}
