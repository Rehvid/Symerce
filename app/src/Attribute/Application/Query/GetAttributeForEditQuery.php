<?php

declare (strict_types = 1);

namespace App\Attribute\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetAttributeForEditQuery implements QueryInterface
{
    public function __construct(
        public int $attributeId,
    ) {}
}
