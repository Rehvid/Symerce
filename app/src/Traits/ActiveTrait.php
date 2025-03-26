<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => '0'])]
    private bool $isActive = true;

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $status): void
    {
        $this->isActive = $status;
    }
}
