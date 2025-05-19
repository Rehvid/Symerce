<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Attribute;

use App\DTO\Admin\Request\PersistableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveAttributeRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)]  public string $name,
    ) {
    }
}
