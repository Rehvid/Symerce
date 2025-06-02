<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Dto;

use App\Common\Domain\Entity\Attribute;

final readonly class AttributeValueData
{
    public function __construct(
        public string $value,
        public Attribute $attribute,
    ) {}
}
