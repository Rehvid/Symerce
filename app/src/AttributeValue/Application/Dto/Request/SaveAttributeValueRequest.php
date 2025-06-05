<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequest
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 1)]  public string $value,
        #[Assert\NotBlank]  public int $attributeId
    ) {
    }
}
