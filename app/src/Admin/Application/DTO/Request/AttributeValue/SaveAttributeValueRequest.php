<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\AttributeValue;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeValueRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 1)]  public string $value,
        #[Assert\NotBlank]  public int $attributeId
    ) {
    }
}
