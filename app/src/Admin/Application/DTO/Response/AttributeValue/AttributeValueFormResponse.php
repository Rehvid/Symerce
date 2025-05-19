<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\AttributeValue;


final readonly class AttributeValueFormResponse
{
    public function __construct(
        public string $value
    ) {
    }
}
