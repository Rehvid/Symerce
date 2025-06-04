<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

interface SluggerInterface
{
    public function slugifyUnique(string $value, string $entityClass, string $fieldName): string;
}
