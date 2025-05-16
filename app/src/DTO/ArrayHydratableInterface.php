<?php

declare(strict_types=1);

namespace App\DTO;

interface ArrayHydratableInterface
{
    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self;
}
