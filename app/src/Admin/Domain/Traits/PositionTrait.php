<?php

declare(strict_types=1);

namespace App\Admin\Domain\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PositionTrait
{
    #[ORM\Column(name: 'position', type: 'integer', nullable: false, options: ['default' => '0'])]
    private int $position = 0;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
