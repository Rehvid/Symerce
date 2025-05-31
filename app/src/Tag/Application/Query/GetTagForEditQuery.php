<?php

declare(strict_types=1);

namespace App\Tag\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class GetTagForEditQuery implements QueryInterface
{
    public function __construct(
        public int $tagId
    ) {}
}
