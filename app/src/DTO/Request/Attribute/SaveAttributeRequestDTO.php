<?php

declare(strict_types=1);

namespace App\DTO\Request\Attribute;

use App\DTO\Request\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)]  public string $name,
    ) {
    }
}
