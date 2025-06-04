<?php

declare(strict_types=1);

namespace App\Common\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PositionChangeRequest
{
    #[Assert\NotBlank]
    public int $movedId;

    #[Assert\NotBlank]
    public int $newPosition;

    #[Assert\NotBlank]
    public int $oldPosition;

    public function __construct(
        int $movedId,
        int $newPosition,
        int $oldPosition,
    ) {
        $this->movedId = $movedId;
        $this->newPosition = $newPosition;
        $this->oldPosition = $oldPosition;
    }
}
