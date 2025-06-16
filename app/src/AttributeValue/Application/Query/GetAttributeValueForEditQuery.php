<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Query;

use App\Common\Application\Query\Interfaces\QueryInterface;

final readonly class GetAttributeValueForEditQuery implements QueryInterface
{
    public function __construct(
        public int $attributeValueId,
    ) {
    }
}
