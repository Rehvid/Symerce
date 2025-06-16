<?php

declare(strict_types=1);

namespace App\Common\Application\Service;

use App\Common\Application\Contracts\SluggerInterface;

final readonly class SlugService
{
    public function __construct(
        private SluggerInterface $sluggerService,
    ) {
    }

    public function makeUnique(
        string $fallback,
        ?string $proposed,
        string $entityClass,
        string $field = 'slug'
    ): string {
        $base = '' !== trim((string) $proposed) ? $proposed : $fallback;

        return $this->sluggerService->slugifyUnique((string) $base, $entityClass, $field);
    }
}
