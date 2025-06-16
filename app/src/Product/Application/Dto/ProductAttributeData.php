<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;

final readonly class ProductAttributeData
{
    public function __construct(
        public Attribute $attribute,
        public string|AttributeValue $value,
        public bool $isCustom
    ) {
    }
}
