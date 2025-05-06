<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\AttributeValue;

use App\DTO\Admin\Request\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 1)]  public string $value,
        #[Assert\NotBlank]  public int $attributeId
    ) {

    }
}
