<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto\Response;


final readonly class AttributeValueFormResponse
{
    public function __construct(
        public string $value
    ) {
    }
}
