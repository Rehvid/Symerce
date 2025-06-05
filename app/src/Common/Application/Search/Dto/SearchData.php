<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Dto;

use App\Common\Domain\Enums\DirectionType;
use App\Common\Domain\Filter\FilterValue;

final readonly class SearchData
{
    /** @param FilterValue[] $filters */
    public function __construct(
        public array $filters = [],
        public ?DirectionType $directionType,
        public ?string $sortBy,
        public int $limit,
        public int $offset,
        public int $page,
    ) {}
}
