<?php

declare(strict_types=1);

namespace App\DTO\Request\AttributeValue;

use App\DTO\Request\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 1)]  public string $value,
        #[Assert\NotBlank]  public int $attributeId
    ) {

    }
}
