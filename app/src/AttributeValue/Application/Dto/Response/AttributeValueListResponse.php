<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto\Response;

final readonly class AttributeValueListResponse
{
    public function __construct(
        public int $id,
        public string $value
    ) {
    }
}
