<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

interface ArrayHydratableInterface
{
    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self;
}
