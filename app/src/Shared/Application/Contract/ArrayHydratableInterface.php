<?php

declare(strict_types=1);

namespace App\Shared\Application\Contract;

interface ArrayHydratableInterface
{
    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self;
}
