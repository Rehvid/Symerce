<?php

declare(strict_types=1);

namespace App\Admin\Application\Contract;

interface SluggerInterface
{
    public function slugifyUnique(string $value, string $entityClass, string $fieldName): string;
}
