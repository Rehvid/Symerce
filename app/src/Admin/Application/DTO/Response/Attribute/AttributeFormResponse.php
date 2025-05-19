<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Attribute;


final readonly class AttributeFormResponse
{
    public function __construct(
        public string $name,
    ) {
    }
}
