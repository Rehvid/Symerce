<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ActivatableInterface
{
    public function isActive(): bool;
    public function setActive(bool $status): void;
}
