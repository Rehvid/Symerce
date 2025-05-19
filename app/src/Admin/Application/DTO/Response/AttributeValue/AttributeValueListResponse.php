<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\AttributeValue;


final readonly class AttributeValueListResponse
{
    public function __construct(
        public int $id,
        public string $value
    ) {
    }
}
