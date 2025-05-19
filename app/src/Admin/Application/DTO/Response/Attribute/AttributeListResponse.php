<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Attribute;


final readonly class AttributeListResponse
{
    public function __construct(
        public int $id,
        public string $name
    ) {
    }
}
