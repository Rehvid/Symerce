<?php

declare(strict_types=1);

namespace App\Common\Domain\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PositionTrait
{
    #[ORM\Column(name: 'position', type: 'integer', nullable: false, options: ['default' => '999'])]
    private int $position = 999;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
