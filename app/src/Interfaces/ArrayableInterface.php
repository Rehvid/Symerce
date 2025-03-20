<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ArrayableInterface
{
    public function toArray(array $additionalData = []): array;
}
