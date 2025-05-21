<?php

declare(strict_types=1);

namespace App\Shared\Application\DTO\Filter;

use App\Shared\Domain\Enums\DirectionType;

final readonly class SearchCriteria
{
    /** @param FilterCondition[] $filters */
    public function __construct(
        public array   $filters,
        public ?string $sortField     = null,
        public DirectionType  $sortDirection = DirectionType::ASC,
        public int     $limit         = 0,
        public int     $offset        = 0,
        public int  $page          = 1,
    ) {}
}
