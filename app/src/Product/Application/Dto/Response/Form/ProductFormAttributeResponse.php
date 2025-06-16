<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response\Form;

use App\Common\Application\Dto\OptionItem;

final readonly class ProductFormAttributeResponse
{
    public function __construct(
        public string|OptionItem $value,
        public bool $isCustom,
    ) {
    }
}
