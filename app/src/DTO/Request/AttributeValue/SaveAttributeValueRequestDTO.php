<?php

declare(strict_types=1);

namespace App\DTO\Request\AttributeValue;

use App\Interfaces\PersistableInterface;

use Symfony\Component\Validator\Constraints as Assert;

readonly class SaveAttributeValueRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)]  public string $value,
        #[Assert\NotBlank] public ?int $attributeId
    ) {

    }
}
