<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Tag;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveTagRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
    ) {
    }
}
