<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class OrderRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank]  public int $movedId,
        #[Assert\NotBlank]  public int $newPosition,
        #[Assert\NotBlank]  public int $oldPosition,
    ) {

    }
}
