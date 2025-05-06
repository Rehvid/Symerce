<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Tag;

use App\DTO\Admin\Request\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveTagRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
    ) {
    }
}
