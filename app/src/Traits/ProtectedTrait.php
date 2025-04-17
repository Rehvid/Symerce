<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ProtectedTrait
{
    #[ORM\Column(type: 'boolean')]
    private bool $isProtected = false;

    public function isProtected(): bool
    {
        return $this->isProtected;
    }

    public function setIsProtected(bool $isProtected): void
    {
        $this->isProtected = $isProtected;
    }

    #[ORM\PreRemove]
    public function preventRemovalIfProtected(): void
    {
        if ($this->isProtected) {
            throw new \RuntimeException(sprintf('Cannot delete protected setting: "%s"', $this->name));
        }
    }
}
