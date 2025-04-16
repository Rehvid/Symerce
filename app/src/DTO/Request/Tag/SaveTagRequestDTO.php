<?php

declare(strict_types=1);

namespace App\DTO\Request\Tag;

use App\Interfaces\PersistableInterface;
use Symfony\Component\Validator\Constraints as Assert;
readonly class SaveTagRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
    ) {}
}
